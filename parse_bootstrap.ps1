$jsonContent = Get-Content -Raw -Path "e:\AntiGravity\script_body_3.txt"
$json = ConvertFrom-Json $jsonContent

# Let's inspect the keys of the JSON object to see where conversation data is
Write-Output "Keys of bootstrap JSON:"
$json.PSObject.Properties.Name | Out-String | Write-Output

# Let's write a small script to find any conversation or share details in this object
# We can scan the properties recursively
function Find-PropertiesRecurse($obj, $path = "") {
    if ($obj -eq $null) { return }
    
    if ($obj -is [string]) {
        if ($obj -match 'buatkan' -or $obj -match 'sports' -or $obj -match 'tech' -or $obj -match 'laravel') {
            # Check if this string is JSON itself
            if ($obj.StartsWith('{') -or $obj.StartsWith('[')) {
                try {
                    $nested = ConvertFrom-Json $obj
                    Find-PropertiesRecurse $nested ($path + "->(JSON)")
                } catch {
                    Write-Output "String at $path matches (length: $($obj.Length))"
                    Write-Output "Preview: $($obj.Substring(0, [Math]::Min(200, $obj.Length)))"
                }
            } else {
                Write-Output "String at $path matches (length: $($obj.Length))"
                Write-Output "Preview: $($obj.Substring(0, [Math]::Min(200, $obj.Length)))"
            }
        }
        return
    }
    
    if ($obj -is [System.Collections.IDictionary] -or $obj.PSObject -ne $null) {
        $props = $null
        if ($obj -is [System.Collections.IDictionary]) {
            $props = $obj.Keys
        } else {
            $props = $obj.PSObject.Properties.Name
        }
        foreach ($prop in $props) {
            $val = $null
            if ($obj -is [System.Collections.IDictionary]) {
                $val = $obj[$prop]
            } else {
                $val = $obj.$prop
            }
            Find-PropertiesRecurse $val ($path + "." + $prop)
        }
    } elseif ($obj -is [System.Collections.IEnumerable]) {
        $idx = 0
        foreach ($item in $obj) {
            Find-PropertiesRecurse $item ($path + "[" + $idx + "]")
            $idx++
        }
    }
}

Write-Output "Searching for conversation text inside bootstrap JSON..."
Find-PropertiesRecurse $json
