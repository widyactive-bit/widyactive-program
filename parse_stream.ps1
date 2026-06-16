$filePath = 'C:\Users\ideba\.gemini\antigravity\brain\50d55630-60b4-4900-821b-b79dafc5cd3a\.system_generated\steps\6\content.md'
$content = Get-Content -Raw -Path $filePath

# Extract the body of the script that contains window.__reactRouterContext.streamController.enqueue
$matches = [regex]::Matches($content, '<script[^>]*>window\.__reactRouterContext\.streamController\.enqueue\(([\s\S]*?)\);?\s*</script>')
Write-Output "Found $($matches.Count) stream script tags."

if ($matches.Count -gt 0) {
    $scriptBody = $matches[0].Groups[1].Value
    # Save the raw script body for inspection
    $scriptBody | Out-File -FilePath "e:\AntiGravity\stream_raw.txt" -Encoding utf8
    Write-Output "Saved raw stream script to stream_raw.txt"
    
    # Let's extract all strings in the format "..."
    # Since it's JSON-like or JS code, we can find double-quoted strings.
    # Note: the string may contain escaped quotes, so we need a regex for escaped strings: "([^"\\]|\\.)*"
    $stringRegex = '"((?:[^"\\]|\\.)*)"'
    $strMatches = [regex]::Matches($scriptBody, $stringRegex)
    Write-Output "Found $($strMatches.Count) string matches inside the stream."
    
    # Let's find strings longer than 100 characters, which are likely conversation messages
    $messages = @()
    foreach ($m in $strMatches) {
        $val = $m.Groups[1].Value
        # Unescape common JS escape sequences
        $decoded = $val -replace '\\n', "`r`n" -replace '\\r', "`r" -replace '\\t', "`t" -replace '\\"', '"' -replace '\\\\', '\'
        if ($decoded.Length -gt 100) {
            $messages += $decoded
        }
    }
    
    Write-Output "Found $($messages.Count) long text segments. Saving them to stream_messages.txt"
    $messagesText = ""
    for ($i = 0; $i -lt $messages.Count; $i++) {
        $messagesText += "=== Text Segment $i (Length: $($messages[$i].Length)) ===`r`n"
        $messagesText += $messages[$i]
        $messagesText += "`r`n`r`n=================================================================`r`n`r`n"
    }
    $messagesText | Out-File -FilePath "e:\AntiGravity\stream_messages.txt" -Encoding utf8
    Write-Output "Created stream_messages.txt"
} else {
    Write-Output "Could not find stream script tag."
}
