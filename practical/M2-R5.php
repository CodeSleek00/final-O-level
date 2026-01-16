<?php
include("../db_connect.php");
$q = $conn->query("SELECT * FROM practical_question");
$data = [];
while($row = $q->fetch_assoc()){
    $data[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Code Practice</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <!-- LEFT -->
    <div class="left">
        <h3>Question</h3>
        <div id="questionBox">Click Next</div>

        <div class="nav-btns">
            <button onclick="prevQ()">◀ Prev</button>
            <button onclick="nextQ()">Next ▶</button>
        </div>
    </div>

    <!-- CENTER -->
    <div class="center">
        <div class="top-bar">
            <button onclick="loadAnswer()">Show Answer</button>
            <button onclick="runCode()">Run ▶</button>
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
    <div class="right">
        <iframe id="output"></iframe>
    </div>

</div>

<script>
const questions = <?= json_encode($data) ?>;
let index = -1;

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
    document.getElementById("questionBox").innerText =
        (index+1) + ". " + questions[index].question;

    // Reset editor on question change
    document.getElementById("codeEditor").value =
`<!DOCTYPE html>
<html>
<body>

</body>
</html>`;
}

function loadAnswer(){
    if(index >= 0){
        document.getElementById("codeEditor").value =
            questions[index].answer;
    }
}

function runCode(){
    document.getElementById("output").srcdoc =
        document.getElementById("codeEditor").value;
}
</script>

</body>
</html>
