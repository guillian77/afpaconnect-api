$SCRIPTPATH = Split-Path $SCRIPT:MyInvocation.MyCommand.Path -parent
$ToBuildPath = "$SCRIPTPATH\base\src"
$converter = "$SCRIPTPATH\converter.ps1"

$version = "1.0"
$copyright = "https://guillian-aufrere.fr"

# Clean builded directory before.
Remove-Item "$SCRIPTPATH\builded\*.exe"

# Convert RSI Launcher for HOTAS PS1 source file.
ls "$ToBuildPath\windows_installer.ps1" | %{
	."$converter" "$($_.Fullname)" "$($_.Fullname -replace '.ps1','.exe')" `
    -verbose `
    -title "Project Installer" `
    -description "Project installer for custom AFPA PHP framework." `
    -version "$version" `
    -product "Project installer for custom AFPA PHP framework." `
    -copyright "$copyright"}
Move-Item "$ToBuildPath\*.exe" "$SCRIPTPATH\builded"