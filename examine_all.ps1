$filePath = 'C:\Users\ideba\.gemini\antigravity\brain\50d55630-60b4-4900-821b-b79dafc5cd3a\.system_generated\steps\6\content.md'
$content = Get-Content -Raw -Path $filePath

Write-Output "File size: $($content.Length) characters"

$keywords = @("laravel", "sports", "tech", "startup", "buatkan")
foreach ($kw in $keywords) {
    $matches = [regex]::Matches($content, "(?i)$kw")
    Write-Output "Keyword '$kw' found $($matches.Count) times"
    if ($matches.Count -gt 0) {
        $index = $content.IndexOf($kw, [System.StringComparison]::OrdinalIgnoreCase)
        $start = [Math]::Max(0, $index - 200)
        $len = [Math]::Min($content.Length - $start, 500)
        Write-Output "  First match context: $($content.Substring($start, $len))"
        Write-Output "---------------------------------------------"
    }
}
