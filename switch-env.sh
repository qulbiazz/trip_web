#!/usr/bin/env bash

set -euo pipefail

if [[ $# -ne 1 ]]; then
  echo "Usage: ./switch-env.sh [laragon|mamp]"
  exit 1
fi

case "$1" in
  laragon)
    cp .env.laragon .env
    ;;
  mamp)
    cp .env.mamp .env
    ;;
  *)
    echo "Unknown environment: $1"
    echo "Use: laragon or mamp"
    exit 1
    ;;
esac

php artisan config:clear

echo "Switched to $1 environment."
echo "Note: run 'php artisan cache:clear' after your database server is running."
