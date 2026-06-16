$jsonContent = Get-Content -Raw -Path "e:\AntiGravity\script_body_3.txt"

# Let's find matches of text containing "Vercel" and "Render" and "SQLite" in the script body
# which is the text we saw earlier.
$matches = [regex]::Matches($jsonContent, '"text":"([^"]+)"')
Write-Output "Found $($matches.Count) 'text' property matches."

$conversations = @()
for ($i = 0; $i -lt $matches.Count; $i++) {
    $textVal = $matches[$i].Groups[1].Value
    # Replace escaped quotes and newlines for readability
    $readable = $textVal -replace '\\n', "`r`n" -replace '\\"', '"'
    Write-Output "Match $i length: $($readable.Length)"
    Write-Output "Preview: $($readable.Substring(0, [Math]::Min(300, $readable.Length)))"
    Write-Output "=========================================================="
    $conversations += $readable
}

# Save all text chunks found to a file
$conversations | Out-File -FilePath "e:\AntiGravity\all_texts.txt" -Encoding utf8
