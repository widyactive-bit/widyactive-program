$filePath = 'C:\Users\ideba\.gemini\antigravity\brain\50d55630-60b4-4900-821b-b79dafc5cd3a\.system_generated\steps\6\content.md'
$content = Get-Content -Raw -Path $filePath
if ($content -match '<script id="__NEXT_DATA__" type="application/json">([\s\S]*?)</script>') {
    $jsonText = $Matches[1]
    $json = ConvertFrom-Json $jsonText
    
    $sharedResponse = $json.props.pageProps.sharedResponse
    $conversation = $null
    if ($sharedResponse -and $sharedResponse.conversation) {
        $conversation = $sharedResponse.conversation
    } else {
        $serverResponse = $json.props.pageProps.serverResponse
        if ($serverResponse -and $serverResponse.data -and $serverResponse.data.conversation) {
            $conversation = $serverResponse.data.conversation
        }
    }
    
    if ($conversation -and $conversation.mapping) {
        $messages = @()
        foreach ($key in $conversation.mapping.PSObject.Properties.Name) {
            $node = $conversation.mapping.$key
            if ($node -and $node.message -and $node.message.content) {
                $author = $node.message.author.role
                $parts = $node.message.content.parts
                $text = $parts -join "`n"
                if ($text -and $text.Trim() -ne "") {
                    $messages += [PSCustomObject]@{
                        Author = $author
                        Text = $text
                    }
                }
            }
        }
        $messagesText = ""
        foreach ($msg in $messages) {
            $messagesText += "=== Message (${msg.Author}) ===`r`n${msg.Text}`r`n`r`n"
        }
        $messagesText | Out-File -FilePath 'e:\AntiGravity\extracted_chat.txt' -Encoding utf8
        Write-Output "Successfully extracted messages to extracted_chat.txt"
    } else {
        Write-Output "Conversation mapping not found in JSON."
    }
} else {
    Write-Output "No __NEXT_DATA__ script found."
}
