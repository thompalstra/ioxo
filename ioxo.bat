@echo off

@setlocal

set IOXO_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%IOXO_PATH%ioxo" %*

@endlocal
