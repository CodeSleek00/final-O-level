<?php
include("../db_connect.php");

/* Fetch HTML practical questions */
$q = $conn->query("SELECT * FROM practical_questions WHERE subject='HTML' ORDER BY chapter, id");
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
<title>HTML Code Practice</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box}
body{
    font-family:'Poppins',sans-serif;
    background:#f8fafc;
    color:#1e293b;
}

/* BANNER */
.it-banner{
    background:#0f172a;
    color:#fff;
    padding:40px 20px;
    text-align:center;
}
.it-banner h1{font-size:2.4rem;margin-bottom:10px}
.it-banner p{opacity:.9}

/* LAYOUT */
.container{padding:20px}
.main-content{
    display:flex;
    gap:20px;
    min-height:650px;
}

/* LEFT PANEL */
.left-panel{
    width:30%;
    background:#fff;
    border-radius:12px;
    padding:20px;
    display:flex;
    flex-direction:column;
    box-shadow:0 4px 10px rgba(0,0,0,.08);
}
.question-header{
    display:flex;
    justify-content:space-between;
    margin-bottom:15px;
    border-bottom:2px solid #e2e8f0;
    padding-bottom:10px;
}
.question-counter{
    background:#3b82f6;
    color:#fff;
    padding:4px 14px;
    border-radius:20px;
    font-size:14px;
}
#questionBox{
    flex:1;
    overflow-y:auto;
    background:#f8fafc;
    padding:15px;
    border-radius:8px;
    border:1px solid #e2e8f0;
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
    border-radius:6px;
    cursor:pointer;
}
.nav-btns button:first-child{background:#e5e7eb}
.nav-btns button:last-child{background:#3b82f6;color:#fff}

/* CENTER */
.center-panel{
    width:40%;
    background:#fff;
    border-radius:12px;
    display:flex;
    flex-direction:column;
    overflow:hidden;
    box-shadow:0 4px 10px rgba(0,0,0,.08);
}
.editor-header{
    display:flex;
    gap:10px;
    padding:15px;
    border-bottom:2px solid #e2e8f0;
}
.editor-header button{
    flex:1;
    padding:10px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    color:#fff;
}
.editor-header button:first-child{background:#10b981}
.editor-header button:last-child{background:#f59e0b}
#codeEditor{
    flex:1;
    padding:15px;
    border:none;
    font-family:monospace;
    font-size:14px;
    background:#020617;
    color:#e5e7eb;
}

/* RIGHT */
.right-panel{
    width:30%;
    background:#fff;
    border-radius:12px;
    display:flex;
    flex-direction:column;
    overflow:hidden;
    box-shadow:0 4px 10px rgba(0,0,0,.08);
}
.output-header{
    padding:15px;
    border-bottom:2px solid #e2e8f0;
}
#output{
    flex:1;
    border:none;
    width:100%;
}

/* IMAGE */
.q-image{
    max-width:100%;
    margin-top:15px;
    border-radius:8px;
    box-shadow:0 4px 10px rgba(0,0,0,.15);
}

/* MOBILE */
@media(max-width:900px){
    .main-content{flex-direction:column}
    .left-panel,.center-panel,.right-panel{width:100%}
}
</style>
</head>
<body>

<?php include 'navbar.html'; ?>

<section class="it-banner">
    <h1>HTML Code Practice</h1>
    <p>Practice HTML practical questions with live preview</p>
</section>

<div class="container">
    <div class="main-content">

        <!-- LEFT -->
        <div class="left-panel">
            <div class="question-header">
                <h3>Question</h3>
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
                <button onclick="runCode()">Run Code</button>
            </div>

<textarea id="codeEditor">
<!DOCTYPE html>
<html>
<body>

</body>
</html>
</textarea>
        </div>

        <!-- RIGHT -->
        <div class="right-panel">
            <div class="output-header">
                <h3>Preview</h3>
            </div>
            <iframe id="output"></iframe>
        </div>

    </div>
</div>

<script>
const questions = <?= json_encode($data) ?>;
let index = -1;

function updateCounter(){
    document.getElementById("questionCounter").innerText =
        (index+1) + "/" + questions.length;
}

function nextQ(){
    if(index < questions.length-1){ index++; showQuestion(); }
}
function prevQ(){
    if(index > 0){ index--; showQuestion(); }
}

function showQuestion(){
    const q = questions[index];

    let img = "";
    if(q.image){
        img = `<img src="../admin/uploads/${q.image}" class="q-image">`;
    }

    document.getElementById("questionBox").innerHTML = `
        <b style="color:#3b82f6">Chapter:</b> ${q.chapter}<br><br>
        <div>${q.question}</div>
        ${img}
    `;

    document.getElementById("codeEditor").value =
`<!DOCTYPE html>
<html>
<body>

</body>
</html>`;

    document.getElementById("output").srcdoc = "";
    updateCounter();
}

function loadAnswer(){
    if(index>=0){
        document.getElementById("codeEditor").value = questions[index].answer;
    }
}
function runCode(){
    document.getElementById("output").srcdoc =
        document.getElementById("codeEditor").value;
}
</script>

</body>
</html>
