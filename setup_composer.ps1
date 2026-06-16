# 1. Update PATH in the current process
$env:Path = [System.Environment]::GetEnvironmentVariable('Path','Machine') + ';' + [System.Environment]::GetEnvironmentVariable('Path','User')

Write-Output "Checking where php.exe is installed by searching the PATH..."
$phpPath = Get-Command php -ErrorAction SilentlyContinue
if ($phpPath) {
    Write-Output "Found PHP in PATH: $($phpPath.Source)"
    php -v
} else {
    Write-Output "PHP is not in PATH yet. Searching common local paths..."
    $searchPaths = @(
        "$env:LOCALAPPDATA\Microsoft\WinGet\Packages",
        "$env:LOCALAPPDATA\Programs",
        "C:\Program Files"
    )
    foreach ($sp in $searchPaths) {
        $found = Get-ChildItem -Path $sp -Filter php.exe -Recurse -Depth 3 -ErrorAction SilentlyContinue
        if ($found) {
            Write-Output "Found PHP at: $($found.FullName)"
            $phpDir = Split-Path $found.FullName
            $env:Path += ";$phpDir"
            Write-Output "Added $phpDir to temporary PATH."
            php -v
            break
        }
    }
}

Write-Output "Downloading composer.phar..."
Invoke-WebRequest -Uri 'https://getcomposer.org/composer.phar' -OutFile 'e:\AntiGravity\composer.phar'
Write-Output "Verifying Composer..."
if (Test-Path 'e:\AntiGravity\composer.phar') {
    php e:\AntiGravity\composer.phar --version
} else {
    Write-Error "Failed to download composer.phar"
}
