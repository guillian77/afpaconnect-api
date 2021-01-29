@echo off

set projectName="afpaconnect"
set envPath="C:\laragon\"
set devPath="Z:\Users\Dekadmin\Desktop\afpaconnect\"
set configFile="config_afpaconnect_dev.ini"
set hrefName="www\"


WHOAMI /GROUPS | FIND "12288" >NUL
SET /A Elevated = 1 - %ERRORLEVEL%
AT > NUL
IF %Elevated% EQU 1 (
    echo -----------------------------------------------
    echo Create symbolics links from your dev directory
    echo -----------------------------------------------

    if not exist %envPath%"files\" (
        mkdir %envPath%"files\"
    )
    if not exist %envPath%"modules\" (
        mkdir %envPath%"modules\"
    )

    if exist %envPath%"files\"%projectName% (
        rmdir %envPath%files\%projectName%
    )

    if exist %envPath%"modules\"%projectName% (
        rmdir %envPath%"modules\"%projectName%
    )

    if exist %envPath%%hrefName%%projectName% (
        rmdir %envPath%%hrefName%%projectName%
    )

    if exist %envPath%"files\"%configFile% (
        rm %envPath%files\%configFile%
    )

    MKLINK /D %envPath%"files\"%projectName% %devPath%"DEV\files"
    MKLINK %envPath%"files\"%configFile% %devPath%"DEV\files\"%configFile%
    MKLINK /D %envPath%"modules\"%projectName% %devPath%"DEV\modules"
    MKLINK /D %envPath%%hrefName%%projectName% %devPath%"DEV\web"

) ELSE (
    echo -----------------------------------------------
    echo /!\ ALERT /!\
    echo -----------------------------------------------
    echo YOU SHOULD RUN THIS INSTALLER WITH ADMIN PRIVILEGES!
    PING 127.0.0.1 > NUL 2>&1
    EXIT /B 5
)

pause