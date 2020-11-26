@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../bartlett/umlwriter/bin/umlwriter
php "%BIN_TARGET%" %*
