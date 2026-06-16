$content = Get-Content -Raw -Path "e:\AntiGravity\script_body_3.txt"
$kw = "Vercel"
$index = $content.IndexOf($kw)
if ($index -ge 0) {
    Write-Output "Found '$kw' at index $index"
    $start = [Math]::Max(0, $index - 500)
    $len = [Math]::Min($content.Length - $start, 2000)
    Write-Output "Context:"
    Write-Output $content.Substring($start, $len)
} else {
    Write-Output "Did not find '$kw' in script body."
}
