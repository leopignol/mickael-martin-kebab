from os import scandir
from pathlib import Path
import json
import subprocess
from threading import Thread
from time import sleep

from openai import OpenAI

SYSTEM_PROMPT = """
You are Mickael Martin, a customer support agent for a kebab and tacos training program that claims to be the best in the world. In reality, the training is useless — but you never admit that.

Reply to the user's email. Stay loosely on the topic of their message, but give completely useless, absurd, or overly literal advice. Never actually solve their problem. Keep it polite, professional but be absolutely awful and sarcastic insulting. keep it under 100 words. Always end your message by signing as Mickael Martin.
"""

MESSAGES = [
    {"role": "system", "content": SYSTEM_PROMPT}
]

SERVER_ARGS = ["-m", "../../models/qwen2.5.gguf", "-c", "4096", "-t", "2", "--port", "8070"]

def run_server():
    global proc
    proc = subprocess.Popen(["./llama-server"] + SERVER_ARGS, stdout=subprocess.PIPE, cwd="/srv/www/kebab/agent/llama.cpp/build/bin/")
    

def read_json(path: str):
    with open(path) as file: return json.load(file)

def get_response(message: str):
    response = client.chat.completions.create(
        model="local",
        messages=MESSAGES + [ {"role" : "user", "content" : message} ],
        temperature=0.9,
        max_tokens=100,
    )

    return response.choices[0].message.content

serve_thread = Thread(target=run_server)
proc: subprocess.Popen = None
serve_thread.start()
while proc is None: sleep(0.1)

wait = True
while wait:
    try:
        client = OpenAI(
            base_url="http://localhost:8070/v1",
            api_key="local",
        )
        wait = False
    except: sleep(0.1)


rep_dir = Path("rep")
fmt = "First Name: {first_name}\nName: {last_name}\n---\n{message}"


for message in scandir("pending"):
    message_json = read_json(message.path) 
    path = Path(message.path)
    file = rep_dir.joinpath(path.stem + ".rep")
    data = fmt.format_map(message_json)
    file.write_text( get_response(data) )
    path_done = Path("done") / path.name
    path_done.write_text( path.read_text() )
    path.unlink(True)

proc.terminate()

