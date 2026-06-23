#!/bin/bash
set -eo pipefail

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
  local main_scss="$SPECTRAL_UI/src/main.scss"
  echo "→ Building widmo: $name"

  # main.scss has a hardcoded theme import path. Patch it before building,
  # restore it afterwards — even on error via trap.
  cp "$main_scss" "${main_scss}.bak"
  trap 'mv "${main_scss}.bak" "$main_scss" 2>/dev/null; trap - RETURN' RETURN
  sed -i.tmp "s|themes/spectral-chromatic/|themes/$name/|g" "$main_scss"
  rm -f "${main_scss}.tmp"

  # 1. Showcase build — generates CSS (index-*.css)
  (cd "$SPECTRAL_UI" && THEME="$name" npm run build 2>&1)

  local dist="$SPECTRAL_UI/dist/$name/assets"
  if [ ! -d "$dist" ]; then
    echo "✗ Showcase build failed — dist not found: $dist" >&2
    return 1
  fi

  local css_src
  css_src=$(ls -S "$dist"/index-*.css 2>/dev/null | head -1)
  if [ -z "$css_src" ]; then
    echo "✗ Build failed — index-*.css missing in $dist" >&2
    return 1
  fi

  # 2. CMS bundle — single IIFE file with no dynamic imports (no 404 chunks)
  (cd "$SPECTRAL_UI" && THEME="$name" npm run build:cms 2>&1)

  local cms_dist="$SPECTRAL_UI/dist-cms/$name"
  local js_src="$cms_dist/cms.js"
  if [ ! -f "$js_src" ]; then
    echo "✗ CMS build failed — cms.js missing in $cms_dist" >&2
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
