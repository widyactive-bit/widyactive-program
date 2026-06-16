# Setup all paths and create Laravel project
$phpDir = "C:\Users\ideba\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe"
$env:Path = "$phpDir;" + [System.Environment]::GetEnvironmentVariable('Path','Machine') + ';' + [System.Environment]::GetEnvironmentVariable('Path','User')

Set-Location "e:\AntiGravity"

Write-Output "Creating Laravel 11 project..."
php composer.phar create-project laravel/laravel widyactive --prefer-dist 2>&1
Write-Output "Done creating Laravel project."
