#!/bin/bash
#--------------------------------------------------
# Name : run-tests.sh
# Author : CDasse
# Purpose : Cleanup the database fixture before
#           and after lunching tests
# Usage : ./run-tests.sh
#--------------------------------------------------

set -euo pipefail

echo "[1/3] DataBase reinitialisation"
symfony console doctrine:fixtures:load -n

echo "[2/3] Run tests"
npx playwright test

echo "[3/3] DataBase reinitialisation"
symfony console doctrine:fixtures:load -n
