@echo off
rem Regenera la carpeta dist/ (HTML puro para Vercel) desde los archivos PHP.
cd /d "%~dp0"

where php >nul 2>nul
if %errorlevel%==0 (
  php tools\exportar-estatico.php
) else if exist "C:\xampp\php\php.exe" (
  "C:\xampp\php\php.exe" tools\exportar-estatico.php
) else (
  echo No encontre PHP. Instala XAMPP o agrega php al PATH.
)

echo.
pause
