<?php
include("../db_connect.php");

if(!isset($_GET['id'])){
    die("Invalid Request");
}

$id = intval($_GET['id']);
$q = $conn->query("SELECT * FROM practical_questions WHERE id=$id");
$data = $q->fetch_assoc();

if(!$data){
    die("Question not found");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>O Level Practical Questions</title>
<style>
body{
    font-family:Segoe UI, Arial;
    background:#f4f6f9;
    padding:20px;
}
.box{
    background:#fff;
    padding:20px;
    border-radius:8px;
    box-shadow:0 3px 10px rgba(0,0,0,.1);
}
.question{
    font-size:18px;
    font-weight:600;
    margin-bottom:15px;
}
.answer{
    background:#f9f9f9;
    padding:15px;
    border-left:4px solid #0066cc;
    white-space:pre-wrap;
}
.back{
    margin-top:20px;
    display:inline-block;
    color:#0066cc;
}
</style>
</head>
<body>

<div class="box">
    <div class="question">
        📌 <?php echo htmlspecialchars($data['question']); ?>
    </div>

    <div class="answer">
        <?php echo htmlspecialchars($data['answer']); ?>
    </div>

    <a class="back" href="python_practicals.php">← Back to Practicals</a>
</div>

</body>
</html>
