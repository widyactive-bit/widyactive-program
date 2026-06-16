Write-Output "Scanning E:\ drive for php.exe..."
Get-ChildItem -Path E:\ -Filter php.exe -Recurse -Depth 3 -ErrorAction SilentlyContinue | Select-Object FullName | Out-String | Write-Output

Write-Output "Scanning C:\ drive for php.exe..."
Get-ChildItem -Path C:\ -Filter php.exe -Recurse -Depth 3 -ErrorAction SilentlyContinue | Select-Object FullName | Out-String | Write-Output

Write-Output "Scanning E:\ drive for composer..."
Get-ChildItem -Path E:\ -Filter composer* -Recurse -Depth 3 -ErrorAction SilentlyContinue | Select-Object FullName | Out-String | Write-Output

Write-Output "Scanning C:\ drive for composer..."
Get-ChildItem -Path C:\ -Filter composer* -Recurse -Depth 3 -ErrorAction SilentlyContinue | Select-Object FullName | Out-String | Write-Output
