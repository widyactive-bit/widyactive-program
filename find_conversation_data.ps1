$filePath = 'C:\Users\ideba\.gemini\antigravity\brain\50d55630-60b4-4900-821b-b79dafc5cd3a\.system_generated\steps\6\content.md'
$content = Get-Content -Raw -Path $filePath

$matches = [regex]::Matches($content, '<script([^>]*)>([\s\S]*?)</script>')
Write-Output "Found $($matches.Count) script tags."

for ($i = 0; $i -lt $matches.Count; $i++) {
    $attrs = $matches[$i].Groups[1].Value
    $body = $matches[$i].Groups[2].Value
    Write-Output "Script $i attributes: $attrs"
    if ($body -match 'buatkan' -or $body -match 'sports' -or $body -match 'startup') {
        Write-Output "  -> Script $i contains keywords! Length: $($body.Length)"
        # Write first 500 and last 500 chars of this script
        Write-Output "  -> Start: $($body.Substring(0, [Math]::Min(500, $body.Length)))"
        Write-Output "  -> End: $($body.Substring([Math]::Max(0, $body.Length - 500)))"
        
        # Save script body to a file
        $body | Out-File -FilePath "e:\AntiGravity\script_body_$i.txt" -Encoding utf8
    }
}
