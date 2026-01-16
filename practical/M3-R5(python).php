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

<!-- Pyodide -->
<script src="https://cdn.jsdelivr.net/pyodide/v0.24.1/full/pyodide.js"></script>

<style>
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background: #f8fafc;
    color: #1e293b;
}
.container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    padding: 20px;
}
.main-content {
    display: flex;
    gap: 20px;
    flex: 1;
    min-height: 600px;
}
/* LEFT PANEL */
.left-panel {
    flex: 0 0 30%;
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    display: flex;
    flex-direction: column;
}
.question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 10px;
}
#questionBox {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background: #f1f5f9;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 15px;
}
.nav-btns {
    display: flex;
    gap: 10px;
}
.nav-btns button {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 8px;
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
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
}
.editor-header {
    display: flex;
    gap: 10px;
    padding: 15px;
    border-bottom: 2px solid #e2e8f0;
    background: #f8fafc;
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
/* CODE EDITOR */
#codeEditor {
    flex: 1;
    padding: 15px;
    border: none;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    resize: none;
    background: #0f172a;
    color: #e2e8f0;
    outline: none;
}
/* RIGHT PANEL */
.right-panel {
    flex: 0 0 30%;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    display: flex;
    flex-direction: column;
}
.output-header {
    padding: 15px;
    border-bottom: 2px solid #e2e8f0;
    background: #f8fafc;
}
#output {
    flex: 1;
    padding: 15px;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    background: #f1f5f9;
    overflow-y: auto;
    white-space: pre-wrap;
}
</style>
</head>
<body>

<div class="container">
    <div class="main-content">
        <!-- LEFT PANEL -->
        <div class="left-panel">
            <div class="question-header">
                <h3>Python Challenge</h3>
                <div class="question-counter" id="questionCounter">0/0</div>
            </div>
            <div id="questionBox">Click Next to start practicing</div>
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
print("Hello Python World!")
            </textarea>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right-panel">
            <div class="output-header"><h3>Output</h3></div>
            <pre id="output"></pre>
        </div>
    </div>
</div>

<script>
let pyodide = null;
let pyodideReady = false;

// Load Pyodide
async function loadPyodideAndPackages() {
    pyodide = await loadPyodide();
    pyodideReady = true;
}
loadPyodideAndPackages();

// Sample Questions
const questions = [
    { chapter: "Basics", question: "Print Hello World", answer: "print('Hello World')" },
    { chapter: "Variables", question: "Assign a variable x = 5", answer: "x = 5\nprint(x)" },
    { chapter: "Loops", question: "Print 1 to 5 using for loop", answer: "for i in range(1,6):\n    print(i)" }
];

let index = -1;

function updateCounter(){
    const total = questions.length;
    const current = index >= 0 ? index + 1 : 0;
    document.getElementById("questionCounter").textContent = `${current}/${total}`;
}

function nextQ(){
    if(index < questions.length - 1){
        index++;
        showQuestion();
    }
}
function prevQ(){
    if(index > 0){
        index--;
        showQuestion();
    }
}

function showQuestion(){
    if(index >=0 && index < questions.length){
        const q = questions[index];
        document.getElementById("questionBox").innerHTML = `
            <div><strong>Chapter:</strong> ${q.chapter}</div>
            <div style="margin-top:8px; padding:10px; border-left:3px solid #3b82f6; background:#f1f5f9;">${q.question}</div>
        `;
        updateCounter();
        document.getElementById("codeEditor").value = "# Write your Python code here\n";
        document.getElementById("output").textContent = "";
    }
}

function loadAnswer(){
    if(index >= 0 && index < questions.length){
        document.getElementById("codeEditor").value = questions[index].answer;
        document.getElementById("output").textContent = questions[index].answer;
    }
}

async function runCode(){
    if(!pyodideReady){
        alert("Python interpreter is still loading...");
        return;
    }
    const code = document.getElementById("codeEditor").value;
    try{
        const output = await pyodide.runPythonAsync(code);
        if(output !== undefined) document.getElementById("output").textContent = output;
    } catch(err){
        document.getElementById("output").textContent = err;
    }
}

// Initialize counter
document.addEventListener('DOMContentLoaded', updateCounter);
</script>

</body>
</html>
