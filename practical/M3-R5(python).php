<?php
include("../db_connect.php");

// Fetch only Python questions
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
<title>Python Practice</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
body{font-family:'Poppins',sans-serif;background:#f8fafc;margin:0;padding:20px;color:#1e293b;}
.container{display:flex;flex-direction:column;min-height:100vh;gap:20px;}
.main-content{display:flex;flex:1;gap:20px;min-height:600px;}

/* Left Panel */
.left-panel{flex:0 0 30%;background:white;border-radius:12px;padding:24px;box-shadow:0 4px 6px -1px rgb(0 0 0 / 0.1);display:flex;flex-direction:column;overflow:hidden;}
.question-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;padding-bottom:16px;border-bottom:2px solid #e2e8f0;}
.question-header h3{font-size:1.5rem;font-weight:600;color:#334155;}
.question-counter{background:#3b82f6;color:white;padding:6px 16px;border-radius:20px;font-size:0.875rem;font-weight:500;text-align:center;}
#questionBox{flex:1;overflow-y:auto;padding:20px;background:#f8fafc;border-radius:8px;border:1px solid #e2e8f0;font-size:1rem;line-height:1.7;margin-bottom:20px;}
.nav-btns{display:flex;gap:12px;margin-top:auto;padding-top:20px;border-top:1px solid #e2e8f0;}
.nav-btns button{flex:1;padding:12px 20px;border:none;border-radius:8px;font-weight:500;cursor:pointer;transition:all 0.2s ease;}
.nav-btns button:first-child{background:#f1f5f9;color:#475569;} 
.nav-btns button:first-child:hover{background:#e2e8f0;}
.nav-btns button:last-child{background:#3b82f6;color:white;}
.nav-btns button:last-child:hover{background:#2563eb;}

/* Center Panel */
.center-panel{flex:0 0 40%;display:flex;flex-direction:column;background:white;border-radius:12px;overflow:hidden;box-shadow:0 4px 6px -1px rgb(0 0 0 / 0.1);}
.editor-header{display:flex;gap:12px;padding:20px;background:#f8fafc;border-bottom:2px solid #e2e8f0;}
.editor-header button{flex:1;padding:12px 20px;border:none;border-radius:8px;font-weight:500;cursor:pointer;transition:all 0.2s ease;}
.editor-header button:first-child{background:#10b981;color:white;}
.editor-header button:first-child:hover{background:#059669;}
.editor-header button:last-child{background:#f59e0b;color:white;}
.editor-header button:last-child:hover{background:#d97706;}
#codeEditor{flex:1;padding:20px;border:none;font-family:monospace;font-size:14px;line-height:1.5;background:#0f172a;color:#e2e8f0;outline:none;resize:none;tab-size:4;}

/* Right Panel */
.right-panel{flex:0 0 30%;background:white;border-radius:12px;overflow:hidden;box-shadow:0 4px 6px -1px rgb(0 0 0 / 0.1);display:flex;flex-direction:column;}
.output-header{padding:20px;background:#f8fafc;border-bottom:2px solid #e2e8f0;flex-shrink:0;}
.output-header h3{font-size:1.5rem;font-weight:600;color:#334155;}
#output{flex:1;width:100%;border:none;background:white;min-height:400px;overflow:auto;padding:10px;font-family:monospace;}

/* Responsive */
@media(max-width:768px){.main-content{flex-direction:column;}.left-panel,.center-panel,.right-panel{flex:none;width:100%;}}
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
<div id="questionBox">Click Next to start</div>
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
<textarea id="codeEditor" placeholder="Write your Python code here...">print("Hello World")</textarea>
</div>

<!-- RIGHT PANEL -->
<div class="right-panel">
<div class="output-header"><h3>Output</h3></div>
<div id="output"></div>
</div>

</div>
</div>

<script>
const questions = <?= json_encode($data) ?>;
let index = -1;

function updateCounter(){
    const total = questions.length;
    const current = index>=0 ? index+1 : 0;
    document.getElementById("questionCounter").textContent = `${current}/${total}`;
}

function nextQ(){ if(index<questions.length-1){index++; showQuestion();} }
function prevQ(){ if(index>0){index--; showQuestion();} }

function showQuestion(){
    if(index>=0 && index<questions.length){
        const q = questions[index];
        document.getElementById("questionBox").innerHTML = `<div style="margin-bottom:15px;"><strong>Chapter:</strong> ${q.chapter}</div><div style="background:white;padding:15px;border-radius:6px;border-left:4px solid #3b82f6;">${q.question}</div>`;
        updateCounter();
        document.getElementById("codeEditor").value = 'print("Hello World")';
        document.getElementById("output").innerHTML = '';
    }
}

function loadAnswer(){
    if(index>=0 && index<questions.length){
        document.getElementById("codeEditor").value = questions[index].answer;
    }
}

function runCode(){
    const code = document.getElementById("codeEditor").value;

    // Send code to server for execution via AJAX
    fetch('run_python.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'code='+encodeURIComponent(code)
    })
    .then(response=>response.text())
    .then(data=>{
        document.getElementById("output").innerText = data;
    });
}

document.addEventListener('DOMContentLoaded',()=>{updateCounter();});
</script>

</body>
</html>
