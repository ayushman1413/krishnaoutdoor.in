#!/bin/bash
# Deploy local changes (laravel/ + public_html/) to Hostinger via rsync over SSH.
#
# Usage:
#   ./deploy.sh app      # sync laravel/ (app code, routes, migrations, etc.)
#   ./deploy.sh public    # sync public_html/ (web root: css/js/images/index.php)
#   ./deploy.sh all        # sync both
#
# Uses the dedicated SSH key at ~/.ssh/krishna_outdoor (passwordless, key-only).

set -euo pipefail

SSH_PORT=65002
SSH_USER="u606581843"
SSH_HOST="46.202.182.2"
SSH_KEY="${HOME}/.ssh/krishna_outdoor"

# Remote paths — confirm these with `ls ~/domains/krishnaoutdoor.in/` over SSH
# if the sync reports "No such file or directory".
REMOTE_BASE="~/domains/krishnaoutdoor.in"
REMOTE_LARAVEL="${REMOTE_BASE}/laravel"
REMOTE_PUBLIC="${REMOTE_BASE}/public_html"

LOCAL_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
LOCAL_LARAVEL="${LOCAL_DIR}/laravel"
LOCAL_PUBLIC="${LOCAL_DIR}/public_html"

RSYNC_OPTS=(
  -avz
  --progress
  -e "ssh -p ${SSH_PORT} -i ${SSH_KEY}"
  --exclude ".env"
  --exclude ".env.*"
  --exclude ".git"
  --exclude ".DS_Store"
  --exclude "node_modules"
  --exclude "storage/logs/*"
  --exclude "storage/framework/cache/*"
  --exclude "storage/framework/sessions/*"
  --exclude "storage/framework/views/*"
)

sync_app() {
  echo "==> Syncing laravel/ (app code) to ${REMOTE_LARAVEL}"
  rsync "${RSYNC_OPTS[@]}" "${LOCAL_LARAVEL}/" "${SSH_USER}@${SSH_HOST}:${REMOTE_LARAVEL}/"
}

sync_public() {
  echo "==> Syncing public_html/ (web root) to ${REMOTE_PUBLIC}"
  rsync "${RSYNC_OPTS[@]}" "${LOCAL_PUBLIC}/" "${SSH_USER}@${SSH_HOST}:${REMOTE_PUBLIC}/"
}

case "${1:-}" in
  app)
    sync_app
    ;;
  public)
    sync_public
    ;;
  all)
    sync_app
    sync_public
    ;;
  *)
    echo "Usage: $0 {app|public|all}"
    exit 1
    ;;
esac

echo "==> Done. If you changed migrations, SSH in and run: php artisan migrate --force"
