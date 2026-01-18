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
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}
body{
    font-family:'Poppins',sans-serif;
    background:#f8fafc;
    color:#1e293b;
}
.container{
    width:98%;
    margin:auto;
}
.main-content{
    display:flex;
    gap:20px;
    min-height:800px;
}

/* LEFT PANEL */
.left-panel{
    flex:0 0 30%;
    background:#fff;
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
    margin-bottom:10px;
    border-bottom:2px solid #e2e8f0;
    padding-bottom:8px;
}
.question-counter{
    background:#3b82f6;
    color:#fff;
    padding:4px 12px;
    border-radius:20px;
    font-size:14px;
}
#questionBox{
    flex:1;
    overflow:auto;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    padding:15px;
    border-radius:8px;
}
.nav-btns{
    display:flex;
    gap:10px;
    margin-top:15px;
}
.nav-btns button{
    flex:1;
    padding:10px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:500;
}
.nav-btns button:first-child{
    background:#e5e7eb;
}
.nav-btns button:last-child{
    background:#2563eb;
    color:white;
}
.nav-btns button:first-child:hover{
    background:#cbd5e1;
}
.nav-btns button:last-child:hover{
    background:#1d4ed8;
}

/* CENTER PANEL */
.center-panel{
    flex:0 0 40%;
    background:white;
    border-radius:12px;
    display:flex;
    flex-direction:column;
    overflow:hidden;
    box-shadow:0 4px 6px rgba(0,0,0,0.1);
}
.editor-header{
    display:flex;
    gap:10px;
    padding:15px;
    background:#f1f5f9;
    border-bottom:2px solid #e2e8f0;
}
.editor-header button{
    flex:1;
    padding:10px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:500;
}
.editor-header button:first-child{
    background:#e5e7eb;
}
.editor-header button:last-child{
    background:#22c55e;
    color:white;
}
.editor-header button:last-child:hover{
    background:#16a34a;
}
#codeEditor{
    flex:1;
    background:#0f172a;
    color:#e2e8f0;
    border:none;
    resize:none;
    padding:15px;
    font-family:monospace;
    font-size:14px;
}

/* RIGHT PANEL */
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
    background:#f8fafc;
    font-family:monospace;
    overflow:auto;
}

/* BANNER */
.it-banner{
    background:url('../image/bg.svg');
    background-size:cover;
    padding:40px 20px;
    border-radius:18px;
    margin:20px;
    color:white;
    text-align:center;
    background-color:black;
}

/* MOBILE FIX */
@media(max-width:768px){
    .main-content{
        flex-direction:column;
    }
    .left-panel{
        min-height:300px;
    }
    .center-panel{
        min-height:520px;
    }
    #codeEditor{
        height:420px;
        font-size:15px;
    }
    .right-panel{
        min-height:260px;
    }
}
</style>
</head>

<body>

<?php include 'navbar.html'; ?>

<section class="it-banner">
    <h1>Python Code Practice</h1>
    <p>Practice Python coding questions based on NIELIT O-Level syllabus</p>
</section>

<div class="container">
<div class="main-content">

<!-- LEFT -->
<div class="left-panel">
    <div class="question-header">
        <h3>Python Questions</h3>
        <div class="question-counter" id="questionCounter">0/0</div>
    </div>
    <div id="questionBox"></div>
    <div class="nav-btns">
        <button onclick="prevQ()">← Previous</button>
        <button onclick="nextQ()">Next →</button>
    </div>
</div>

<!-- CENTER -->
<div class="center-panel">
    <div class="editor-header">
        <button onclick="loadAnswer()">Show Answer</button>
        <button onclick="runCode()">▶ Run</button>
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

/* SHUFFLE QUESTIONS */
function shuffle(arr){
    for(let i=arr.length-1;i>0;i--){
        const j=Math.floor(Math.random()*(i+1));
        [arr[i],arr[j]]=[arr[j],arr[i]];
    }
}
shuffle(questions);

let index = 0;

/* AUTO LOAD FIRST QUESTION */
window.onload = () => {
    showQuestion();
};

function updateCounter(){
    document.getElementById("questionCounter").innerText =
        (index+1)+"/"+questions.length;
}

function showQuestion(){
    const q = questions[index];
    let img = "";
    if(q.image){
        img = `<img src="../admin/uploads/${q.image}" style="width:100%;margin:10px 0;border-radius:8px">`;
    }
    document.getElementById("questionBox").innerHTML = `
        <b>Chapter:</b> ${q.chapter}<br><br>
        ${img}
        ${q.question}
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
    document.getElementById("codeEditor").value =
        questions[index].answer || "# No answer available";
}

/* PYODIDE */
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
sys.stdout=sys.stderr=O()
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
