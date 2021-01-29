# - Hide the console -
$t = '[DllImport("user32.dll")] public static extern bool ShowWindow(int handle, int state);'
add-type -name win -member $t -namespace native
[native.win]::ShowWindow(([System.Diagnostics.Process]::GetCurrentProcess() | Get-Process).MainWindowHandle, 0)

[System.Reflection.Assembly]::LoadWithPartialName("System.Windows.Forms")
Add-Type -AssemblyName System.Windows.Forms

$dirScript = [Environment]::CurrentDirectory
$dirConfig = "$dirScript\config.ini"
$dirDesktop = [Environment]::GetFolderPath('Desktop')
$WScriptShell = New-Object -ComObject WScript.Shell

function getValues($formTitle, $textTitle){
    [void] [System.Reflection.Assembly]::LoadWithPartialName("System.Drawing")
    [void] [System.Reflection.Assembly]::LoadWithPartialName("System.Windows.Forms")

    $objForm = New-Object System.Windows.Forms.Form
    $objForm.Text = $formTitle
    $objForm.Size = New-Object System.Drawing.Size(300,200)
    $objForm.StartPosition = "CenterScreen"

    $objForm.KeyPreview = $True
    $objForm.Add_KeyDown({if ($_.KeyCode -eq "Enter") {$x=$objTextBox.Text;$objForm.Close()}})
    $objForm.Add_KeyDown({if ($_.KeyCode -eq "Escape") {$objForm.Close()}})

    $OKButton = New-Object System.Windows.Forms.Button
    $OKButton.Location = New-Object System.Drawing.Size(75,120)
    $OKButton.Size = New-Object System.Drawing.Size(75,23)
    $OKButton.Text = "VALIDER"
    $OKButton.Add_Click({$Script:userInput=$objTextBox.Text;$objForm.Close()})
    $objForm.Controls.Add($OKButton)

    $CANCELButton = New-Object System.Windows.Forms.Button
    $CANCELButton.Location = New-Object System.Drawing.Size(150,120)
    $CANCELButton.Size = New-Object System.Drawing.Size(75,23)
    $CANCELButton.Text = "ANNULER"
    $CANCELButton.Add_Click({$objForm.Close()})
    $objForm.Controls.Add($CANCELButton)

    $objLabel = New-Object System.Windows.Forms.Label
    $objLabel.Location = New-Object System.Drawing.Size(10,20)
    $objLabel.Size = New-Object System.Drawing.Size(280,30)
    $objLabel.Text = $textTitle
    $objForm.Controls.Add($objLabel)

    $objTextBox = New-Object System.Windows.Forms.TextBox
    $objTextBox.Location = New-Object System.Drawing.Size(10,50)
    $objTextBox.Size = New-Object System.Drawing.Size(260,20)
    $objForm.Controls.Add($objTextBox)

    $objForm.Topmost = $True

    $objForm.Add_Shown({$objForm.Activate()})

    [void] $objForm.ShowDialog()

    return "afpaconnect"
#    return $userInput
}

Function Select-Env-Type
{
    Add-Type -AssemblyName System.Windows.Forms
    Add-Type -AssemblyName System.Drawing

    $form = New-Object System.Windows.Forms.Form
    $form.Text = 'Envirronnement'
    $form.Size = New-Object System.Drawing.Size(300,200)
    $form.StartPosition = 'CenterScreen'

    $okButton = New-Object System.Windows.Forms.Button
    $okButton.Location = New-Object System.Drawing.Point(75,120)
    $okButton.Size = New-Object System.Drawing.Size(75,23)
    $okButton.Text = 'VALIDER'
    $okButton.DialogResult = [System.Windows.Forms.DialogResult]::OK
    $form.AcceptButton = $okButton
    $form.Controls.Add($okButton)

    $cancelButton = New-Object System.Windows.Forms.Button
    $cancelButton.Location = New-Object System.Drawing.Point(150,120)
    $cancelButton.Size = New-Object System.Drawing.Size(75,23)
    $cancelButton.Text = 'ANNULER'
    $cancelButton.DialogResult = [System.Windows.Forms.DialogResult]::Cancel
    $form.CancelButton = $cancelButton
    $form.Controls.Add($cancelButton)

    $label = New-Object System.Windows.Forms.Label
    $label.Location = New-Object System.Drawing.Point(10,20)
    $label.Size = New-Object System.Drawing.Size(280,20)
    $label.Text = 'Selectionner env developpement:'
    $form.Controls.Add($label)

    $listBox = New-Object System.Windows.Forms.ListBox
    $listBox.Location = New-Object System.Drawing.Point(10,40)
    $listBox.Size = New-Object System.Drawing.Size(260,20)
    $listBox.Height = 80

    [void] $listBox.Items.Add('Wamp 64 bit - www')
    [void] $listBox.Items.Add('Wamp 64 bit - htdocs')
    [void] $listBox.Items.Add('Xampp - www')
    [void] $listBox.Items.Add('Xampp - htdocs')
    [void] $listBox.Items.Add('Laragon')

    $form.Controls.Add($listBox)

    $form.Topmost = $true

    $result = $form.ShowDialog()

    if ($result -eq [System.Windows.Forms.DialogResult]::OK)
    {
        $env = $listBox.SelectedItem
    }

    return $env
}

function Message
{
    Param ([string]$text, [string]$title)
    [System.Windows.Forms.MessageBox]::Show("$text", "$title")
}

function SelectAFile
{
    Param ([string]$fileName, [string]$filters)

    if(!$filters)
    {
        $filters = "All files (*.*)|*.*"
    }

    $fileLocation = New-Object System.Windows.Forms.OpenFileDialog -Property @{
        InitialDirectory = $dirDesktop
        Title = "Selectionner votre fichier de configuration: $fileName"
        Filter = "$filters"
    }

    $dialogResult = $fileLocation.ShowDialog()
    $fileLocation = $fileLocation.FileName

    if($dialogResult -eq "Cancel")
    {
        Message -text "Vous devez specifier le chemin de $fileName." -title "Erreur"
        exit
    }

    return $fileLocation
}

Function Get-Folder($message="")
{
    [System.Reflection.Assembly]::LoadWithPartialName("System.windows.forms")|Out-Null

    $foldername = New-Object System.Windows.Forms.FolderBrowserDialog
    $foldername.Description = $message
    $foldername.rootfolder = "MyComputer"
    $foldername.SelectedPath = ""

    if($foldername.ShowDialog() -eq "OK")
    {
        $folder += $foldername.SelectedPath
    }
    return $folder
}

Function createDirIfNotExist($dir)
{
    if (-Not (Test-Path "$PATH_ENVDEV/files"))
    {
        New-Item -Name "$PATH_ENVDEV"
    }
}

Function createSymbolicLink()
{
    Param ([string]$path, [string]$target)

    # Test if directory
#    if(-Not (Test-Path $path -PathType Leaf))
#    {
#        [io.directory]::Delete($path)
#        Remove-Item -Path $path -Recurse
#    } else {
#        Remove-Item $path -Force
#    }

    if (Test-Path -Path $path)
    {
        cmd /c rmdir $path
    }

    Message -text $target -title "Lien symbolique: source"
    Message -text $path -title "Lien symbolique: cible"

    New-Item -Force -ItemType SymbolicLink -Path $path -Target $target
}

# Define env path and document root from choosen env software
$env = Select-Env-Type
if ($env -eq "Wamp 64 bit - www") {
    $PATH_ENVDEV = "C:\wamp64"
    $DOC_ROOT = "$PATH_ENVDEV\www"
} elseif ($env -eq "Wamp 64 bit - htdocs") {
    $PATH_ENVDEV = "C:\wamp64"
    $DOC_ROOT = "$PATH_ENVDEV\htdocs"
} elseif ($env -eq "Xampp - www") {
    $PATH_ENVDEV = "C:\xampp"
    $DOC_ROOT = "$PATH_ENVDEV\www"
} elseif ($env -eq "Xampp - htdocs") {
    $PATH_ENVDEV = "C:\xampp"
    $DOC_ROOT = "$PATH_ENVDEV\htdocs"
} elseif ($env -eq "Laragon") {
    $PATH_ENVDEV = "C:\laragon"
    $DOC_ROOT = "$PATH_ENVDEV\www"
}

# Get project name
$PROJ_NAME = getValues "Nom du projet" "Entrer le nom du dossier contenant le projet`nExemple: afpaticket/afpaticket/audace"

# Get different path
$PATH_FILES = Get-Folder("Selectionner le repertoire contenant vos fichiers HTML et SQL (files)")
$PATH_MODULES = Get-Folder("Selectionner le repertoire contenant vos modules PHP (modules)")
$PATH_WEB = Get-Folder("Selectionner le repertoire contenant vos fichiers publics JS/CSS/IMAGES (web)")
#$PATH_CONFIG = SelectAFile("config_projectname_dev.ini")

# Concat paths
$PATH_FILES_STR = [string]::Concat($PATH_ENVDEV, "\files\", $PROJ_NAME)
$PATH_MODULES_STR = [string]::Concat($PATH_ENVDEV, "\modules\", $PROJ_NAME)
$PATH_WEB_STR = [string]::Concat($PATH_WEB, "\", $PROJ_NAME)
#$PATH_CONFIG_STR = [string]::Concat($PATH_ENVDEV, "\files\config_", $PROJ_NAME, "_dev.ini")

# Create folders if does not exist
createDirIfNotExist("$PATH_ENVDEV/files")
createDirIfNotExist("$PATH_ENVDEV/modules")

# Create/Update symlink
createSymbolicLink -target $PATH_FILES -path $PATH_FILES_STR
createSymbolicLink -target $PATH_MODULES -path $PATH_MODULES_STR
createSymbolicLink -target $PATH_WEB -path $PATH_WEB_STR
#createSymbolicLink -target $PATH_CONFIG -path $PATH_CONFIG_STR
