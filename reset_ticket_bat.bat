@echo off
cd /d %~dp0
php artisan queue:truncate >nul 2>&1
exit
