const fs = require('fs');
const path = require('path');

const filePath = 'C:\\Users\\ideba\\.gemini\\antigravity\\brain\\50d55630-60b4-4900-821b-b79dafc5cd3a\\.system_generated\\steps\\6\\content.md';

let htmlContent = fs.readFileSync(filePath, 'utf8');

if (htmlContent.startsWith('Title:')) {
    const parts = htmlContent.split('---');
    if (parts.length > 1) {
        htmlContent = parts.slice(1).join('---');
    }
}

// In ChatGPT shared links, conversation data is usually embedded inside the html, often under a script with id="__NEXT_DATA__" or in the state of the app.
// Let's write a simple regex to extract __NEXT_DATA__ content.
const nextDataMatch = htmlContent.match(/<script id="__NEXT_DATA__" type="application\/json">([\s\S]*?)<\/script>/);

if (nextDataMatch) {
    try {
        const data = JSON.parse(nextDataMatch[1]);
        console.log("Found __NEXT_DATA__ JSON!");
        
        // Let's inspect the structure and extract messages
        const props = data.props || {};
        const pageProps = props.pageProps || {};
        const sharedResponse = pageProps.sharedResponse || {};
        const serverResponse = pageProps.serverResponse || {};
        
        let conversation = sharedResponse.conversation || serverResponse.conversation || null;
        if (!conversation && pageProps.sharedResponse && pageProps.sharedResponse.conversation) {
            conversation = pageProps.sharedResponse.conversation;
        }

        // Sometimes the conversation is nested under pageProps.serverResponse.data.conversation
        if (!conversation && pageProps.serverResponse && pageProps.serverResponse.data) {
            conversation = pageProps.serverResponse.data.conversation;
        }
        
        if (conversation) {
            const messages = [];
            const mapping = conversation.mapping || {};
            for (const key in mapping) {
                const node = mapping[key];
                if (node && node.message && node.message.content) {
                    const author = node.message.author ? node.message.author.role : 'unknown';
                    const parts = node.message.content.parts || [];
                    const text = parts.join('\n');
                    if (text && text.trim()) {
                        messages.push({ author, text });
                    }
                }
            }
            fs.writeFileSync('extracted_messages.json', JSON.stringify(messages, null, 2), 'utf8');
            console.log(`Extracted ${messages.length} messages to extracted_messages.json`);
            
            // Also write a human readable version
            let readable = "";
            messages.forEach((msg, index) => {
                readable += `=== Message ${index + 1} (${msg.author.toUpperCase()}) ===\n${msg.text}\n\n`;
            });
            fs.writeFileSync('extracted_messages.txt', readable, 'utf8');
            console.log("Created readable extracted_messages.txt");
            process.exit(0);
        } else {
            console.log("Could not find conversation object in __NEXT_DATA__ props. Keys in pageProps:", Object.keys(pageProps));
        }
    } catch (e) {
        console.error("Failed to parse __NEXT_DATA__:", e);
    }
} else {
    console.log("No __NEXT_DATA__ script tag found.");
}

// Fallback: simple regex to find divs with message classes or text contents
console.log("Attempting fallback text extraction...");
const cleanHtml = htmlContent.replace(/<script[\s\S]*?<\/script>/gi, '').replace(/<style[\s\S]*?<\/style>/gi, '');
const textMatches = [];
// Find paragraph tags or div content that looks like text
const regex = /<(div|p|span|h1|h2|h3)[^>]*>(.*?)<\/\1>/gi;
let match;
while ((match = regex.exec(cleanHtml)) !== null) {
    let txt = match[2].replace(/<[^>]*>/g, '').trim();
    if (txt.length > 20 && !txt.includes('{') && !txt.includes('}')) {
        textMatches.push(txt);
    }
}
fs.writeFileSync('fallback_text.txt', textMatches.join('\n\n'), 'utf8');
console.log("Fallback text matches written to fallback_text.txt");
