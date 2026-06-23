#!/bin/bash
set -e

THEME=${1:-all}
REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
SPECTRAL_UI="$REPO_ROOT/spectral-ui"
THEME_CSS="$REPO_ROOT/themes/spectral/css"

if [ ! -d "$SPECTRAL_UI/node_modules" ]; then
  echo "→ Installing Spectral UI dependencies..."
  (cd "$SPECTRAL_UI" && npm install)
fi

build_widmo() {
  local name=$1
  echo "→ Building widmo: $name"
  (cd "$SPECTRAL_UI" && THEME="$name" npm run build 2>&1)

  local dist="$SPECTRAL_UI/dist/$name/assets"
  if [ ! -d "$dist" ]; then
    echo "✗ Build failed — dist not found: $dist" >&2
    return 1
  fi

  local css_src js_src
  css_src=$(ls "$dist"/index-*.css 2>/dev/null | head -1)
  js_src=$(ls  "$dist"/index-*.js  2>/dev/null | head -1)

  if [ -z "$css_src" ] || [ -z "$js_src" ]; then
    echo "✗ Build failed — index-*.css or index-*.js missing in $dist" >&2
    return 1
  fi

  mkdir -p "$THEME_CSS/$name"
  cp "$css_src" "$THEME_CSS/$name/main.css"
  cp "$js_src"  "$THEME_CSS/$name/main.js"
  echo "✓ $name → themes/spectral/css/$name/ ($(du -sh "$THEME_CSS/$name/main.css" | cut -f1) CSS, $(du -sh "$THEME_CSS/$name/main.js" | cut -f1) JS)"
}

if [ "$THEME" = "all" ]; then
  for dir in "$SPECTRAL_UI/src/themes"/*/; do
    build_widmo "$(basename "$dir")"
  done
else
  build_widmo "$THEME"
fi

echo "Build complete."
