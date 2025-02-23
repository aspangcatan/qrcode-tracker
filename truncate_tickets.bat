@echo off
SETLOCAL ENABLEDELAYEDEXPANSION

:: Laravel API Endpoint for Truncating Table
SET URL="http://localhost/qrcode-tracker/tickets/truncate"

:: Call Laravel Route using CURL
curl -X GET !URL!

echo.
echo Truncate request sent to Laravel.
pause
