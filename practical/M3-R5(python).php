<?php
include("../db_connect.php");

// Fetch Python questions from DB
$q = $conn->query("SELECT * FROM practical_questions WHERE subject='Python' ORDER BY chapter");
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
<title>Python Code Practice</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f8fafc;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    color: #1e293b;
}

.container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    padding: 20px;
    gap: 20px;
}

/* MAIN CONTENT */
.main-content {
    display: flex;
    flex: 1;
    gap: 20px;
    min-height: 600px;
}

/* LEFT PANEL */
.left-panel {
    flex: 0 0 30%;
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.question-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}
#questionBox {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
    background: #f1f5f9;
    border-radius: 8px;
    margin-bottom: 15px;
}
.nav-btns {
    display: flex;
    gap: 10px;
}
.nav-btns button {
    flex: 1;
    padding: 10px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 500;
}
.nav-btns button:first-child { background: #f1f5f9; }
.nav-btns button:last-child { background: #3b82f6; color: white; }

/* CENTER PANEL */
.center-panel {
    flex: 0 0 40%;
    display: flex;
    flex-direction: column;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.editor-header {
    display: flex;
    gap: 10px;
    padding: 15px;
    background: #f1f5f9;
}
.editor-header button {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
}
.editor-header button:first-child { background: #10b981; color: white; }
.editor-header button:last-child { background: #f59e0b; color: white; }

#codeEditor {
    flex: 1;
    padding: 15px;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    background: #0f172a;
    color: #e2e8f0;
    border: none;
    outline: none;
    resize: none;
}

/* RIGHT PANEL */
.right-panel {
    flex: 0 0 30%;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
}
.output-header { padding: 15px; background: #f1f5f9; }
#output {
    flex: 1;
    padding: 10px;
    background: #f8fafc;
    font-family: 'Courier New', monospace;
    overflow-y: auto;
    white-space: pre-wrap;
}

/* MOBILE */
@media (max-width:768px){
    .main-content { flex-direction: column; }
    .left-panel, .center-panel, .right-panel { flex: none; width: 100%; min-height: auto; }
}
</style>

<!-- Pyodide -->
<script src="https://cdn.jsdelivr.net/pyodide/v0.24.1/full/pyodide.js"></script>
</head>
<body>

<!-- BANNER -->
<section style="text-align:center; background:#3b82f6; color:white; padding:30px; border-radius:12px; margin-bottom:20px;">
    <h1>Python Code Practice</h1>
    <p>Practice Python coding directly in your browser. Click 'Run Code' to see results instantly!</p>
</section>

<div class="container">
<div class="main-content">
    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="question-header">
            <h3>Questions</h3>
            <div id="questionCounter">0/0</div>
        </div>
        <div id="questionBox">Click Next to start practicing Python questions.</div>
        <div class="nav-btns">
            <button onclick="prevQ()">← Previous</button>
            <button onclick="nextQ()">Next →</button>
        </div>
    </div>

    <!-- CENTER PANEL -->
    <div class="center-panel">
        <div class="editor-header">
            <button onclick="loadAnswer()">Show Answer</button>
            <button onclick="runCode()">▶ Run Code</button>
        </div>
        <textarea id="codeEditor">
# Write your Python code here
print("Hello World")
        </textarea>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <div class="output-header"><strong>Output</strong></div>
        <pre id="output"></pre>
    </div>
</div>
</div>

<script>
let pyodideReady = false;
let pyodide = null;

// Load Pyodide
async function loadPyodideAndPackages() {
    pyodide = await loadPyodide();
    pyodideReady = true;
}
loadPyodideAndPackages();

// Questions data from PHP
const questions = <?= json_encode($data) ?>;
let index = -1;

// Update counter
function updateCounter() {
    const total = questions.length;
    const current = index >=0 ? index+1 : 0;
    document.getElementById("questionCounter").textContent = `${current}/${total}`;
}

// Show next/previous question
function nextQ(){
    if(index < questions.length-1){ index++; showQuestion(); }
}
function prevQ(){
    if(index>0){ index--; showQuestion(); }
}

// Display question
function showQuestion(){
    if(index >=0 && index<questions.length){
        const q = questions[index];
        document.getElementById("questionBox").innerHTML = `
            <div><strong>Chapter:</strong> ${q.chapter}</div>
            <div style="margin-top:10px;">${q.question}</div>
        `;
        updateCounter();
        // Reset editor
        document.getElementById("codeEditor").value = "# Write your Python code here\n";
        document.getElementById("output").textContent = "";
    }
}

// Load answer into editor
function loadAnswer(){
    if(index>=0 && index<questions.length){
        document.getElementById("codeEditor").value = questions[index].answer || "# No answer provided";
    }
}

// Run code using Pyodide
async function runCode(){
    if(!pyodideReady){
        alert("Python interpreter is still loading, please wait...");
        return;
    }
    const code = document.getElementById("codeEditor").value;
    try {
        const output = await pyodide.runPythonAsync(code);
        document.getElementById("output").textContent = output !== undefined ? output : "";
    } catch(err){
        document.getElementById("output").textContent = err;
    }
}

// Initialize counter
document.addEventListener('DOMContentLoaded', updateCounter);
</script>

</body>
</html>
