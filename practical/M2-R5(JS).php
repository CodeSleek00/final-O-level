<?php
include("../db_connect.php");

$q = $conn->query("SELECT * FROM practical_questions WHERE subject='JavaScript' ORDER BY chapter, id");
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
<title>HTML || O level Practice</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
/* 🔒 DESIGN UNCHANGED */
*{margin:0;padding:0;box-sizing:border-box}
body{
    font-family:'Poppins',sans-serif;
    background:#f8fafc;
    color:#1e293b;
}
.container{padding:20px;width: 98%;}
.main-content{display:flex;gap:20px;min-height:600px}

/* LEFT */
.left-panel{flex:0 0 30%;background:#fff;border-radius:12px;padding:24px;display:flex;flex-direction:column;box-shadow:0 4px 6px rgb(0 0 0 / 0.1)}
.question-header{display:flex;justify-content:space-between;border-bottom:2px solid #e2e8f0;padding-bottom:15px;margin-bottom:15px}
.question-counter{background:#3b82f6;color:#fff;padding:6px 16px;border-radius:20px}
#questionBox{flex:1;overflow-y:auto;padding:15px;background:#f8fafc;border-radius:8px;border:1px solid #e2e8f0}
.nav-btns{display:flex;gap:10px;margin-top:15px}
.nav-btns button{flex:1;padding:12px;border:none;border-radius:8px;cursor:pointer}
.nav-btns button:last-child{background:#3b82f6;color:#fff}

/* CENTER */
.center-panel{flex:0 0 40%;display:flex;flex-direction:column;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 6px rgb(0 0 0 / 0.1)}
.editor-header{display:flex;gap:10px;padding:15px;border-bottom:2px solid #e2e8f0}
.editor-header button{flex:1;padding:12px;border:none;border-radius:8px;cursor:pointer;color:#fff}
.editor-header button:first-child{background:#10b981}
.editor-header button:last-child{background:#f59e0b}
#codeEditor{flex:1;padding:15px;border:none;resize:none;font-family:monospace;font-size:14px;background:#0f172a;color:#e2e8f0}

/* RIGHT */
.right-panel{flex:0 0 30%;background:#fff;border-radius:12px;display:flex;flex-direction:column;box-shadow:0 4px 6px rgb(0 0 0 / 0.1)}
.output-header{padding:15px;border-bottom:2px solid #e2e8f0}
#output{flex:1;border:none}

/* IMAGE */
.q-image{margin-top:15px;max-width:100%;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,.15)}

/* MOBILE */
@media(max-width:768px){
    .main-content{flex-direction:column}
    .left-panel,.center-panel,.right-panel{width:100%}
    #codeEditor{min-height:420px;font-size:15px}
}
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
</style>
</head>
<body>

<?php include 'navbar.html'; ?>
<!-- BANNER -->
    <section class="it-banner">
        <h1>HTML Code Practice</h1>
        <p>
            Practice HTML coding challenges based on the latest NIELIT syllabus.
            Improve your coding skills with practical HTML questions designed for O Level students.
        </p>
    </section>
<div class="container">
<div class="main-content">

<div class="left-panel">
    <div class="question-header">
        <h3>Code Challenge</h3>
        <div class="question-counter" id="questionCounter">0/0</div>
    </div>
    <div id="questionBox">Loading questions...</div>
    <div class="nav-btns">
        <button onclick="prevQ()">← Previous</button>
        <button onclick="nextQ()">Next →</button>
    </div>
</div>

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

<div class="right-panel">
    <div class="output-header">
        <h3>Preview</h3>
    </div>
    <iframe id="output"></iframe>
</div>

</div>
</div>

<script>
/* ===== QUESTIONS DATA ===== */
let questions = <?= json_encode($data) ?>;
let index = 0;

/* 🔥 SHUFFLE FUNCTION (Fisher–Yates) */
function shuffle(array){
    for(let i = array.length - 1; i > 0; i--){
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

/* Shuffle ONCE on page load */
shuffle(questions);

/* ===== FUNCTIONS ===== */
function updateCounter(){
    document.getElementById("questionCounter").innerText =
        (index + 1) + "/" + questions.length;
}

function showQuestion(){
    const q = questions[index];

    let img = "";
    if(q.image){
        img = `<img src="../admin/uploads/${q.image}" class="q-image">`;
    }

    document.getElementById("questionBox").innerHTML = `
        <b style="color:#3b82f6">Chapter:</b> ${q.chapter}<br><br>
        ${q.question}
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

function loadAnswer(){
    document.getElementById("codeEditor").value =
        questions[index].answer;
}

function runCode(){
    document.getElementById("output").srcdoc =
        document.getElementById("codeEditor").value;
}

/* INIT */
document.addEventListener("DOMContentLoaded", showQuestion);
</script>

</body>
</html>
