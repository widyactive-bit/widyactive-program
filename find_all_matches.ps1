$filePath = 'C:\Users\ideba\.gemini\antigravity\brain\50d55630-60b4-4900-821b-b79dafc5cd3a\.system_generated\steps\6\content.md'
$content = Get-Content -Raw -Path $filePath

$keyword = "buatkan"
$matches = [regex]::Matches($content, $keyword)
Write-Output "Found $($matches.Count) matches for '$keyword' in content.md"

for ($i = 0; $i -lt $matches.Count; $i++) {
    $idx = $matches[$i].Index
    Write-Output "Match $i at index $idx"
    
    # Let's find what HTML element contains this index
    # We can search backwards for '<' and forwards for '>'
    $tagStart = $content.LastIndexOf('<', $idx)
    $tagEnd = $content.IndexOf('>', $idx)
    
    Write-Output "Tag bounds: $tagStart to $tagEnd"
    if ($tagStart -ge 0 -and $tagEnd -gt $tagStart) {
        $tagText = $content.Substring($tagStart, $tagEnd - $tagStart + 1)
        Write-Output "Tag context: $($tagText.Substring(0, [Math]::Min(200, $tagText.Length)))..."
    }
    
    # Print the context around the match
    $start = [Math]::Max(0, $idx - 500)
    $len = [Math]::Min($content.Length - $start, 1000)
    Write-Output "Context:"
    Write-Output $content.Substring($start, $len)
    Write-Output "=========================================================="
}
