<?php
include("../db_connect.php");

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* 🔴 UPDATED DESIGN - IMPROVED MOBILE UX */
* {
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body {
    font-family:'Poppins', sans-serif;
    background:linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    color:#1e293b;
    min-height:100vh;
}

.container {
    display:flex;
    flex-direction:column;
    padding:20px;
    gap:20px;
    width:100%;
    max-width:1600px;
    margin:0 auto;
}

.main-content {
    display:flex;
    gap:20px;
    min-height:800px;
}

/* ================= LEFT PANEL ================= */
.left-panel{
    flex:0 0 30%;
    background:white;
    border-radius:16px;
    padding:20px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    display:flex;
    flex-direction:column;
    border:1px solid #e2e8f0;
}

.question-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    padding-bottom:15px;
    border-bottom:2px solid #e2e8f0;
}

.question-header h3{
    color:#1e293b;
    font-size:1.4rem;
    font-weight:600;
}

.question-counter{
    background:linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color:white;
    padding:6px 16px;
    border-radius:20px;
    font-size:14px;
    font-weight:600;
    box-shadow:0 2px 5px rgba(59, 130, 246, 0.3);
}

#questionBox{
    flex:1;
    overflow-y:auto;
    padding:20px;
    background:#f8fafc;
    border-radius:12px;
    border:1px solid #e2e8f0;
    line-height:1.6;
    font-size:16px;
}

/* NAV BUTTONS - COLORFUL UPDATE */
.nav-btns{
    display:flex;
    gap:12px;
    margin-top:25px;
}

.nav-btns button{
    flex:1;
    padding:14px 5px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
    font-size:15px;
    transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    box-shadow:0 3px 8px rgba(0,0,0,0.1);
}

.nav-btns button:first-child {
    background:linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color:white;
}

.nav-btns button:last-child {
    background:linear-gradient(135deg, #10b981 0%, #059669 100%);
    color:white;
}

.nav-btns button:hover{
    transform:translateY(-2px);
    box-shadow:0 5px 15px rgba(0,0,0,0.15);
}

.nav-btns button:active{
    transform:translateY(0);
}

/* ================= CENTER PANEL ================= */
.center-panel{
    flex:0 0 40%;
    display:flex;
    flex-direction:column;
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    border:1px solid #e2e8f0;
}

.editor-header{
    display:flex;
    gap:12px;
    padding:18px;
    background:linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom:2px solid #e2e8f0;
}

.editor-header button{
    flex:1;
    padding:14px 5px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
    font-size:15px;
    transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    box-shadow:0 3px 8px rgba(0,0,0,0.1);
}

.editor-header button:first-child{
    background:linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color:white;
}

.editor-header button:last-child{
    background:linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color:white;
}

.editor-header button:hover{
    transform:translateY(-2px);
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

.editor-header button:active{
    transform:translateY(0);
}

#codeEditor{
    flex:1;
    padding:20px;
    font-family:'Fira Code', 'Cascadia Code', 'Monaco', 'Courier New', monospace;
    background:#0f172a;
    color:#e2e8f0;
    font-size:15px;
    border:none;
    resize:none;
    line-height:1.5;
    tab-size:4;
}

#codeEditor:focus{
    outline:none;
}

/* ================= RIGHT PANEL ================= */
.right-panel{
    flex:0 0 30%;
    background:white;
    border-radius:16px;
    display:flex;
    flex-direction:column;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    border:1px solid #e2e8f0;
    overflow:hidden;
}

#output{
    flex:1;
    padding:20px;
    font-family:'Fira Code', 'Cascadia Code', 'Monaco', 'Courier New', monospace;
    background:#0f172a;
    color:#e2e8f0;
    overflow:auto;
    font-size:14px;
    line-height:1.5;
    white-space:pre-wrap;
}

/* ================= MOBILE RESPONSIVE ================= */
@media(max-width:768px){
    .container{
        padding:15px;
        gap:15px;
    }
    
    .main-content{
        flex-direction:column;
        gap:15px;
    }
    
    .left-panel, .center-panel, .right-panel{
        flex:1;
        width:100%;
        min-height:auto;
    }
    
    /* CENTER PANEL - HEIGHT INCREASED */
    .center-panel{
        height:520px !important;
        min-height:520px;
    }
    
    #codeEditor{
        height:400px !important;
        min-height:400px;
        font-size:16px;
        padding:18px;
    }
    
    /* RIGHT PANEL - OPTIMIZED HEIGHT */
    .right-panel{
        height:320px;
        min-height:320px;
    }
    
    #output{
        height:260px;
        font-size:15px;
        padding:18px;
    }
    
    /* BETTER BUTTONS FOR MOBILE */
    .nav-btns, .editor-header{
        gap:10px;
    }
    
    .nav-btns button, .editor-header button{
        padding:16px 5px;
        font-size:16px;
    }
    
    /* QUESTION BOX IMPROVED FOR MOBILE */
    #questionBox{
        padding:18px;
        font-size:17px;
        min-height:300px;
        max-height:400px;
    }
}

/* ================= TABLET RESPONSIVE ================= */
@media(min-width:769px) and (max-width:1024px){
    .container{
        padding:15px;
    }
    
    .main-content{
        flex-wrap:wrap;
        min-height:auto;
    }
    
    .left-panel{
        flex:0 0 100%;
        order:1;
        margin-bottom:15px;
    }
    
    .center-panel{
        flex:0 0 55%;
        order:2;
    }
    
    .right-panel{
        flex:0 0 43%;
        order:3;
    }
    
    #codeEditor{
        height:500px;
        min-height:500px;
    }
}

/* ================= BANNER ================= */
/* BANNER */
    .it-banner {
        background: url('../image/bg.svg');
        background-size: cover;
        background-position: center center;
        padding: 40px 20px;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        text-align: center;
        margin: 20px;
        background-color: black;
        color: white;
    }
/* ================= LOADING INDICATOR ================= */
.loading {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(59, 130, 246, 0.3);
    border-radius: 50%;
    border-top-color: #3b82f6;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ================= SCROLLBAR STYLING ================= */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* ================= SUCCESS/ERROR MESSAGES ================= */
.success-msg {
    color: #10b981;
    font-weight: 600;
}

.error-msg {
    color: #ef4444;
    font-weight: 600;
}
</style>
</head>

<body>
<?php include 'navbar.html'; ?>
<!-- BANNER -->
    <section class="it-banner">
        <h1>Python Code Practice</h1>
        <p>
            Practice Python coding challenges based on the latest NIELIT syllabus.
            Improve your coding skills with practical Python questions designed for O Level students.
        </p>
    </section>
<div class="container">
<div class="main-content">

<!-- LEFT -->
<div class="left-panel">
    <div class="question-header">
        <h3>Python Questions</h3>
        <div class="question-counter" id="questionCounter">0/0</div>
    </div>

    <div id="questionBox">Click Next to start practicing!</div>

    <div class="nav-btns">
        <button onclick="prevQ()"><i class="fas fa-arrow-left"></i> Previous</button>
        <button onclick="nextQ()">Next <i class="fas fa-arrow-right"></i></button>
    </div>
</div>

<!-- CENTER -->
<div class="center-panel">
    <div class="editor-header">
        <button onclick="loadAnswer()"><i class="fas fa-lightbulb"></i> Show Answer</button>
        <button onclick="runCode()"><i class="fas fa-play"></i> Run Code</button>
    </div>
    <textarea id="codeEditor" placeholder="# Write your Python code here...">print("Hello World!")</textarea>
</div>

<!-- RIGHT -->
<div class="right-panel">
    <div style="padding:18px;border-bottom:2px solid #e2e8f0;background:#f8fafc;">
        <b style="font-size:16px;"><i class="fas fa-terminal"></i> Output</b>
    </div>
    <pre id="output"></pre>
</div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/pyodide/v0.23.4/full/pyodide.js"></script>

<script>
const questions = <?= json_encode($data) ?>;

// 🔀 SHUFFLE ONLY ONCE
function shuffle(array){
    for(let i=array.length-1;i>0;i--){
        const j=Math.floor(Math.random()*(i+1));
        [array[i],array[j]]=[array[j],array[i]];
    }
}
shuffle(questions);

let index = -1;

function updateCounter(){
    document.getElementById("questionCounter").textContent =
        `${index+1}/${questions.length}`;
}

function showQuestion(){
    const q = questions[index];

    let imgHTML = "";
    if(q.image){
        imgHTML = `<img src="../admin/uploads/${q.image}"
                    style="width:100%;margin:15px 0;border-radius:10px;max-height:300px;object-fit:contain;background:#f1f5f9;padding:10px;">`;
    }

    document.getElementById("questionBox").innerHTML = `
        <div style="margin-bottom:15px;">
            <span style="background:#e0f2fe;color:#0369a1;padding:6px 12px;border-radius:8px;font-weight:600;font-size:14px;">
                Chapter: ${q.chapter}
            </span>
        </div>
        ${imgHTML}
        <div style="margin-top:15px;font-size:17px;">${q.question}</div>
    `;

    document.getElementById("codeEditor").value = "# Write your code here\n# Use the Run button to execute your code\n\n";
    document.getElementById("output").textContent = "Output will appear here...";
    updateCounter();
}

function nextQ(){
    if(index < questions.length-1){
        index++;
        showQuestion();
    } else {
        alert("🎉 You've completed all questions! Review your answers or refresh for a new set.");
    }
}
function prevQ(){
    if(index > 0){
        index--;
        showQuestion();
    }
}

function loadAnswer(){
    if(index >= 0){
        document.getElementById("codeEditor").value =
            questions[index].answer || "# No answer available";
        document.getElementById("output").textContent = "Answer loaded. Click 'Run Code' to see the output.";
    } else {
        alert("Please select a question first!");
    }
}

// PYODIDE
let pyodide;
let pyodideLoading = false;

async function initializePyodide() {
    if (!pyodide && !pyodideLoading) {
        pyodideLoading = true;
        const output = document.getElementById("output");
        output.innerHTML = `<span class="loading"></span> Initializing Python environment...`;
        
        try {
            pyodide = await loadPyodide();
            output.textContent = "✅ Python environment ready! You can now run your code.";
            pyodideLoading = false;
        } catch (error) {
            output.textContent = `❌ Failed to load Python: ${error}`;
            pyodideLoading = false;
        }
    }
}

async function runCode(){
    const code = document.getElementById("codeEditor").value;
    const output = document.getElementById("output");
    
    if (!code.trim()) {
        output.textContent = "⚠️ Please write some code before running!";
        return;
    }
    
    if (!pyodide) {
        output.textContent = "🔄 Loading Python environment, please wait...";
        await initializePyodide();
        if (!pyodide) {
            output.textContent = "❌ Python environment failed to load. Please refresh the page.";
            return;
        }
    }
    
    try {
        output.textContent = "🔄 Running your code...";
        
        await pyodide.runPythonAsync(`
import sys
from js import document

class OutputCapture:
    def write(self, text):
        current = document.getElementById("output").textContent
        if current.includes("Running your code..."):
            document.getElementById("output").textContent = text
        else:
            document.getElementById("output").textContent += text
    
    def flush(self):
        pass

sys.stdout = OutputCapture()
sys.stderr = OutputCapture()
`);
        
        await pyodide.runPythonAsync(code);
        
        if (output.textContent === "🔄 Running your code..." || output.textContent.trim() === "") {
            output.textContent = "✅ Code executed successfully (no output).";
        }
        
    } catch (error) {
        output.textContent = `❌ Error:\n${error}`;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializePyodide();
    
    // Auto-select first question if available
    if (questions.length > 0) {
        index = 0;
        showQuestion();
    }
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'Enter') {
            runCode();
        } else if (e.key === 'ArrowLeft' && e.ctrlKey) {
            prevQ();
        } else if (e.key === 'ArrowRight' && e.ctrlKey) {
            nextQ();
        }
    });
    
    // Show keyboard shortcuts hint
    setTimeout(() => {
        const output = document.getElementById("output");
        if (output && output.textContent.includes("will appear here")) {
            output.textContent = "💡 Tip: Use Ctrl+Enter to run code, Ctrl+Arrow keys to navigate questions.";
        }
    }, 2000);
});
</script>

</body>
</html>