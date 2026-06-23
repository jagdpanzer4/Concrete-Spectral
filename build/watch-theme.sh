#!/bin/bash
# Dev mode: rebuild widmo bundle on source file changes
# Usage: ./build/watch-theme.sh [widmo-name]   default: spectral-chromatic
THEME=${1:-spectral-chromatic}
REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
SPECTRAL_UI="$REPO_ROOT/spectral-ui"

rebuild() {
  echo "Change detected — rebuilding $THEME..."
  "$REPO_ROOT/build/build-themes.sh" "$THEME" && echo "✓ Rebuilt at $(date +%H:%M:%S)"
}

echo "Watching '$THEME' for changes (Ctrl+C to stop)..."
echo "Deploy themes/spectral/ to your CMS and refresh the browser."

while true; do
  if command -v fswatch &>/dev/null; then
    fswatch -1 -r "$SPECTRAL_UI/src" && rebuild
  elif command -v inotifywait &>/dev/null; then
    inotifywait -q -r -e modify,create,delete "$SPECTRAL_UI/src" && rebuild
  else
    sleep 3 && rebuild
  fi
done
