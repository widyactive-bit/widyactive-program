$phpDir = "C:\Users\ideba\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe"
$iniPath = "$phpDir\php.ini"

if (-not (Test-Path $iniPath)) {
    Write-Output "Copying php.ini-development to php.ini..."
    Copy-Item "$phpDir\php.ini-development" $iniPath
}

Write-Output "Enabling common extensions in php.ini..."
$content = Get-Content $iniPath -Raw

# Enable extension_dir = "ext" (Windows paths require this uncommented)
$content = $content -replace ';extension_dir = "ext"', 'extension_dir = "ext"'

# Enable extensions needed for Laravel
$extensions = @("curl", "fileinfo", "mbstring", "openssl", "pdo_sqlite", "sqlite3", "zip", "gd", "xml")
foreach ($ext in $extensions) {
    $content = $content -replace ";extension=$ext", "extension=$ext"
}

$content | Out-File $iniPath -Encoding utf8 -Force
Write-Output "php.ini configured successfully."

# Verify extensions are loaded
$env:Path = [System.Environment]::GetEnvironmentVariable('Path','Machine') + ';' + [System.Environment]::GetEnvironmentVariable('Path','User')
Write-Output "Loaded PHP modules:"
php -m
