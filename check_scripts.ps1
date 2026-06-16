$filePath = 'C:\Users\ideba\.gemini\antigravity\brain\50d55630-60b4-4900-821b-b79dafc5cd3a\.system_generated\steps\6\content.md'
$content = Get-Content -Raw -Path $filePath

# Check if there are any JSON script tags
$matches = [regex]::Matches($content, '<script[^>]*>([\s\S]*?)</script>')
Write-Output "Found $($matches.Count) script tags."

# Find any text that looks like a JSON string in script tags
for ($i = 0; $i -lt $matches.Count; $i++) {
    $scriptText = $matches[$i].Groups[1].Value
    if ($scriptText -like '*"conversation"*' -or $scriptText -like '*"mapping"*') {
        Write-Output "Script tag $i contains 'conversation' or 'mapping' keyword! Length: $($scriptText.Length)"
        # Write first 500 characters of this script
        Write-Output "Preview: $($scriptText.Substring(0, [Math]::Min(1000, $scriptText.Length)))"
        
        # Save it to a file
        $scriptText | Out-File -FilePath "e:\AntiGravity\script_$i.txt" -Encoding utf8
    }
}

# Check for JSON objects stored in variables
# or search for specific words like "buatkan web" which is the user request text
if ($content -match 'buatkan web') {
    Write-Output "Found 'buatkan web' text in the HTML file!"
    # Let's get the context around it
    $index = $content.IndexOf('buatkan web')
    $start = [Math]::Max(0, $index - 500)
    $len = [Math]::Min($content.Length - $start, 1000)
    Write-Output "Context: $($content.Substring($start, $len))"
} else {
    Write-Output "Did not find 'buatkan web' text in HTML."
}
