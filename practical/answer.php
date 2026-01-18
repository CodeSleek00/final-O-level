<?php
include("../db_connect.php");

$id = $_GET['id'] ?? '';
if(!$id){
    echo "Invalid Question"; exit;
}

$q = $conn->query("SELECT * FROM practical_questions WHERE id='{$id}'");
$data = $q->fetch_assoc();

if(!$data){
    echo "Question not found"; exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Answer</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
body{
    font-family:'Poppins',sans-serif;
    background:#f8fafc;
    margin:0;
    padding:30px;
    color:#1e293b;
}
.box{
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
    max-width:900px;
    margin:auto;
}
.question{
    font-size:18px;
    font-weight:600;
    margin-bottom:15px;
}
.answer{
    background:#f1f5f9;
    padding:15px;
    border-left:4px solid #3b82f6;
    white-space:pre-wrap;
    font-family:monospace;
}
.back{
    margin-bottom:20px;
    display:inline-block;
    color:#2563eb;
    text-decoration:none;
}
</style>
</head>
<body>

<a class="back" href="questions.php?subject=<?= urlencode($data['subject']) ?>">← Back to Questions</a>

<div class="box">
    <div class="question">
        <?= htmlspecialchars($data['question']) ?>
    </div>
    <div class="answer">
        <?= htmlspecialchars($data['answer']) ?>
    </div>
</div>

</body>
</html>
