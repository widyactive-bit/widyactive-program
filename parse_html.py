import json
import re
from bs4 import BeautifulSoup

file_path = r"C:\Users\ideba\.gemini\antigravity\brain\50d55630-60b4-4900-821b-b79dafc5cd3a\.system_generated\steps\6\content.md"

with open(file_path, "r", encoding="utf-8") as f:
    html_content = f.read()

# Strip any leading markdown header text if present
if html_content.startswith("Title:"):
    # Split by the first ---
    parts = html_content.split("---", 1)
    if len(parts) > 1:
        html_content = parts[1]

soup = BeautifulSoup(html_content, "html.parser")

# Look for NEXT_DATA or script elements containing JSON share data
# Usually ChatGPT shares have data in a script tag with id="self" or __NEXT_DATA__
# or we can extract the main conversation container text.
# Let's first look for __NEXT_DATA__
next_data = soup.find("script", id="__NEXT_DATA__")
if next_data:
    try:
        data = json.loads(next_data.string)
        # Find shared conversation
        print("Found __NEXT_DATA__ JSON structure!")
        with open("e:\\AntiGravity\\next_data.json", "w", encoding="utf-8") as out:
            json.dump(data, out, indent=2)
    except Exception as e:
        print("Failed to parse __NEXT_DATA__ JSON:", e)

# Let's extract all main text content or print it nicely
# ChatGPT messages are typically inside divs with class/data tags
# Or we can just get the text and clean it up.
print("Extracting all text from divs...")
messages = []
# Let's look for elements with class containing 'message' or 'markdown'
for div in soup.find_all(class_=re.compile("markdown|message|whitespace-pre-wrap")):
    text = div.get_text(separator="\n").strip()
    if text and text not in messages:
        messages.append(text)

with open("e:\\AntiGravity\\extracted_messages.txt", "w", encoding="utf-8") as out:
    for i, msg in enumerate(messages):
        out.write(f"--- Message {i+1} ---\n{msg}\n\n")

print(f"Extracted {len(messages)} messages to extracted_messages.txt")
