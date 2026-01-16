<?php
include("../db_connect.php");
$questions = $conn->query("SELECT * FROM practical_question");
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
        <?php while($q = $questions->fetch_assoc()){ ?>
            <div class="q-item" onclick="loadQuestion(`<?=htmlspecialchars($q['question'])?>`,`<?=htmlspecialchars($q['answer'])?>`)">
                <?= $q['subject'] ?> Question
            </div>
        <?php } ?>
    </div>

    <!-- CENTER -->
    <div class="center">
        <h3 id="questionText">Select a Question</h3>
        <button onclick="toggleAnswer()">Show Answer</button>
        <div id="answerBox"></div>

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

<script src="script.js"></script>
</body>
</html>
