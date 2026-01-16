<?php
include("../db_connect.php");

// Fetch all Python practical questions
$q = $conn->query("SELECT * FROM practical_questions WHERE subject='Python' ORDER BY chapter, id");
$data = [];
while($row = $q->fetch_assoc()){
    $data[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Python Practice Portal</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Poppins', sans-serif; background:#f8fafc; color:#1e293b; line-height:1.6; }
.container { display:flex; flex-direction:column; padding:20px; gap:20px; }
.main-content { display:flex; gap:20px; min-height:800px; }

/* Left Panel */
.left-panel { flex:0 0 30%; background:white; border-radius:12px; padding:20px; box-shadow:0 4px 6px rgba(0,0,0,0.1); display:flex; flex-direction:column; }
.question-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; border-bottom:2px solid #e2e8f0; padding-bottom:10px; }
.question-header h3 { font-size:1.3rem; font-weight:600; }
.question-counter { background:#3b82f6; color:white; padding:4px 12px; border-radius:20px; font-size:0.875rem; font-weight:500; text-align:center; }
#questionBox { flex:1; overflow-y:auto; padding:15px; background:#f8fafc; border-radius:8px; border:1px solid #e2e8f0; font-size:1rem; margin-bottom:10px; }
.nav-btns { display:flex; gap:10px; margin-top:auto; }
.nav-btns button { flex:1; padding:10px; border:none; border-radius:8px; font-weight:500; cursor:pointer; }
.nav-btns button:first-child { background:#f1f5f9; color:#475569; }
.nav-btns button:first-child:hover { background:#e2e8f0; }
.nav-btns button:last-child { background:#3b82f6; color:white; }
.nav-btns button:last-child:hover { background:#2563eb; }

/* Center Panel */
.center-panel { flex:0 0 40%; display:flex; flex-direction:column; background:white; border-radius:12px; overflow:hidden; box-shadow:0 4px 6px rgba(0,0,0,0.1); }
.editor-header { display:flex; gap:10px; padding:15px; background:#f8fafc; border-bottom:2px solid #e2e8f0; }
.editor-header button { flex:1; padding:10px; border:none; border-radius:8px; font-weight:500; cursor:pointer; }
.editor-header button:first-child { background:#10b981; color:white; }
.editor-header button:first-child:hover { background:#059669; }
.editor-header button:last-child { background:#f59e0b; color:white; }
.editor-header button:last-child:hover { background:#d97706; }
#codeEditor { flex:1; padding:15px; font-family:'Courier New', monospace; font-size:14px; line-height:1.5; resize:none; background:#0f172a; color:#e2e8f0; outline:none; }

/* Right Panel */
.right-panel { flex:0 0 30%; background:white; border-radius:12px; overflow:hidden; box-shadow:0 4px 6px rgba(0,0,0,0.1); display:flex; flex-direction:column; }
.output-header { padding:15px; background:#f8fafc; border-bottom:2px solid #e2e8f0; flex-shrink:0; }
.output-header h3 { font-size:1.3rem; font-weight:600; }
#output { flex:1; padding:15px; overflow:auto; background:#f8fafc; font-family:'Courier New', monospace; font-size:14px; white-space:pre-wrap; }

/* Responsive */
@media(max-width:768px){
.main-content{ flex-direction:column; }
.left-panel, .center-panel, .right-panel{ flex:none; width:100%; min-height:auto; }
#codeEditor{ height:300px; }
#output{ height:200px; }
.center-panel {
    height: 500px;
}
}
</style>
</head>
<body>

<div class="container">
<div class="main-content">

<!-- Left Panel -->
<div class="left-panel">
    <div class="question-header">
        <h3>Python Questions</h3>
        <div class="question-counter" id="questionCounter">0/0</div>
    </div>
    <div id="questionBox">Click Next to start practicing</div>
    <div class="nav-btns">
        <button onclick="prevQ()">← Previous</button>
        <button onclick="nextQ()">Next →</button>
    </div>
</div>

<!-- Center Panel -->
<div class="center-panel">
    <div class="editor-header">
        <button onclick="loadAnswer()">Show Answer</button>
        <button onclick="runCode()">▶ Run Code</button>
    </div>
    <textarea id="codeEditor" placeholder="Write your Python code here...">
print("Hello World")
    </textarea>
</div>

<!-- Right Panel -->
<div class="right-panel">
    <div class="output-header"><h3>Output</h3></div>
    <pre id="output"></pre>
</div>

</div>
</div>

<!-- Pyodide -->
<script src="https://cdn.jsdelivr.net/pyodide/v0.23.4/full/pyodide.js"></script>
<script>
let pyodideReady = false;
async function loadPyodideAndPackages() {
    window.pyodide = await loadPyodide();
    pyodideReady = true;
}
loadPyodideAndPackages();

const questions = <?= json_encode($data) ?>;
let index = -1;

function updateCounter(){
    const total = questions.length;
    const current = index>=0?index+1:0;
    document.getElementById("questionCounter").textContent = `${current}/${total}`;
}

function nextQ(){
    if(index < questions.length-1){ index++; showQuestion(); }
}
function prevQ(){
    if(index >0){ index--; showQuestion(); }
}

function showQuestion(){
    if(index>=0 && index<questions.length){
        const q = questions[index];
        document.getElementById("questionBox").innerHTML = `
        <div style="margin-bottom:10px;"><strong>Chapter:</strong> ${q.chapter}</div>
        <div style="background:white;padding:10px;border-left:4px solid #3b82f6;border-radius:4px;">${q.question}</div>`;
        updateCounter();
        document.getElementById("codeEditor").value = "# Write your Python code here\n";
        document.getElementById("output").textContent = "";
    }
}

function loadAnswer(){
    if(index>=0 && index<questions.length){
        document.getElementById("codeEditor").value = questions[index].answer || "# No answer available";
        document.getElementById("output").textContent = "";
    }
}

async function runCode(){
    if(!pyodideReady){ alert("Python is still loading..."); return; }
    const code = document.getElementById("codeEditor").value;
    const outputEl = document.getElementById("output");
    outputEl.textContent = "";
    try{
        await pyodide.runPythonAsync(`
import sys
from js import document
class OutputRedirect:
    def write(self,s):
        if s.strip() != "":
            document.getElementById("output").textContent += s + "\\n"
    def flush(self):
        pass
sys.stdout = OutputRedirect()
sys.stderr = OutputRedirect()
`);
        await pyodide.runPythonAsync(code);
    }catch(err){
        outputEl.textContent = err;
    }
}

// Initialize counter
document.addEventListener('DOMContentLoaded', updateCounter);
</script>

</body>
</html>
