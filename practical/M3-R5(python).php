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

<style>
    /* 🔴 SAME DESIGN — UPDATED UI ONLY */
* {
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body {
    font-family:'Poppins', sans-serif;
    background:#f8fafc;
    color:#1e293b;
}

.container {
    display:flex;
    flex-direction:column;
    padding:20px;
    gap:20px;
    width:98%;
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
    border-radius:12px;
    padding:20px;
    box-shadow:0 4px 6px rgba(0,0,0,0.1);
    display:flex;
    flex-direction:column;
}

.question-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
    border-bottom:2px solid #e2e8f0;
    padding-bottom:10px;
}

.question-counter{
    background:#3b82f6;
    color:white;
    padding:4px 12px;
    border-radius:20px;
    font-size:14px;
}

#questionBox{
    flex:1;
    overflow-y:auto;
    padding:15px;
    background:#f8fafc;
    border-radius:8px;
    border:1px solid #e2e8f0;
}

/* NAV BUTTONS */
.nav-btns{
    display:flex;
    gap:10px;
    margin-top:auto;
}

.nav-btns button{
    flex:1;
    padding:10px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    background:#e5e7eb;
    color:#1e293b;
    font-weight:500;
    transition:0.3s;
}

.nav-btns button:hover{
    background:#3b82f6;
    color:white;
}

/* ================= CENTER PANEL ================= */
.center-panel{
    flex:0 0 40%;
    display:flex;
    flex-direction:column;
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 4px 6px rgba(0,0,0,0.1);
}

.editor-header{
    display:flex;
    gap:10px;
    padding:15px;
    background:#f8fafc;
    border-bottom:2px solid #e2e8f0;
}

.editor-header button{
    flex:1;
    padding:10px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    background:#e5e7eb;
    color:#1e293b;
    font-weight:500;
    transition:0.3s;
}

.editor-header button:hover{
    background:#22c55e;
    color:white;
}

/* RUN BUTTON */
.editor-header button:last-child{
    background:#2563eb !important;
    color:white;
}

.editor-header button:last-child:hover{
    background:#1d4ed8 !important;
}

#codeEditor{
    flex:1;
    padding:15px;
    font-family:monospace;
    background:#0f172a;
    color:#e2e8f0;
    font-size:14px;
    border:none;
    resize:none;
}

/* ================= RIGHT PANEL ================= */
.right-panel{
    flex:0 0 30%;
    background:white;
    border-radius:12px;
    display:flex;
    flex-direction:column;
    box-shadow:0 4px 6px rgba(0,0,0,0.1);
}

#output{
    flex:1;
    padding:15px;
    font-family:monospace;
    background:#f8fafc;
    overflow:auto;
}

/* ================= MOBILE RESPONSIVE ================= */
@media(max-width:768px){
    .main-content{
        flex-direction:column;
    }

    #codeEditor{
        height:520px;   /* 🔥 BIG editor for mobile typing */
        font-size:15px;
    }

    #output{
        height:260px;
    }
}

/* ================= BANNER ================= */
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

    <div id="questionBox">Click Next to start</div>

    <div class="nav-btns">
        <button onclick="prevQ()">← Previous</button>
        <button onclick="nextQ()">Next →</button>
    </div>
</div>

<!-- CENTER -->
<div class="center-panel">
    <div class="editor-header">
        <button onclick="loadAnswer()">Show Answer</button>
        <button onclick="runCode()" style="background:blue;color:white;">▶ Run</button>
    </div>
    <textarea id="codeEditor">print("Hello World")</textarea>
</div>

<!-- RIGHT -->
<div class="right-panel">
    <div style="padding:15px;border-bottom:2px solid #e2e8f0"><b>Output</b></div>
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
                    style="width:100%;margin:10px 0;border-radius:8px">`;
    }

    document.getElementById("questionBox").innerHTML = `
        <b>Chapter:</b> ${q.chapter}<br><br>
        ${imgHTML}
        <div>${q.question}</div>
    `;

    document.getElementById("codeEditor").value = "# Write your code here\n";
    document.getElementById("output").textContent = "";
    updateCounter();
}

function nextQ(){
    if(index < questions.length-1){
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

function loadAnswer(){
    if(index >= 0){
        document.getElementById("codeEditor").value =
            questions[index].answer || "# No answer";
    }
}

// PYODIDE
let pyodide;
loadPyodide().then(p => pyodide = p);

async function runCode(){
    try{
        document.getElementById("output").textContent = "";
        await pyodide.runPythonAsync(`
import sys
from js import document
class O:
    def write(self,s):
        document.getElementById("output").textContent += s
    def flush(self): pass
sys.stdout = sys.stderr = O()
`);
        await pyodide.runPythonAsync(
            document.getElementById("codeEditor").value
        );
    }catch(e){
        document.getElementById("output").textContent = e;
    }
}
</script>

</body>
</html>
