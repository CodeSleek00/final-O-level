<?php
include("../db_connect.php");
$questions = $conn->query("SELECT * FROM practical_question");
$data = [];
while($row = $questions->fetch_assoc()){
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
        <?php foreach($data as $i => $q){ ?>
            <div class="q-item" onclick="loadQuestion(<?= $i ?>)">
                <?= $q['subject'] ?> – Q<?= $i+1 ?>
            </div>
        <?php } ?>
    </div>

    <!-- CENTER -->
    <div class="center">
        <h3 id="questionText">Select a Question</h3>

        <button class="answer-btn" onclick="toggleAnswer()">Show Answer</button>
        <pre id="answerBox"></pre>

        <div class="editor-header">
            <span>HTML Editor</span>
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
let answerVisible = false;

function loadQuestion(index){
    document.getElementById("questionText").innerText = questions[index].question;
    document.getElementById("answerBox").innerText = questions[index].answer;
    document.getElementById("answerBox").style.display = "none";
    answerVisible = false;
}

function toggleAnswer(){
    const box = document.getElementById("answerBox");
    answerVisible = !answerVisible;
    box.style.display = answerVisible ? "block" : "none";
}

function runCode(){
    const code = document.getElementById("codeEditor").value;
    document.getElementById("output").srcdoc = code;
}
</script>

</body>
</html>
