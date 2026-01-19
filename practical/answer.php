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
    padding:20px;
    color:#1e293b;
}

/* CONTAINER */
.container{
    max-width:900px;
    margin:auto;
}

/* BACK */
.back{
    display:inline-block;
    margin-bottom:15px;
    color:#2563eb;
    text-decoration:none;
    font-size:14px;
}

/* CARD */
.box{
    background:white;
    padding:22px;
    border-radius:14px;
    border:1px solid #e5e7eb;
}

/* QUESTION */
.question{
    font-size:18px;
    font-weight:600;
    margin-bottom:15px;
}

/* QUESTION IMAGE */
.question-img{
    margin-bottom:18px;
}

.question-img img{
    max-width:100%;
    border-radius:10px;
    border:1px solid #e5e7eb;
}

/* ANSWER */
.answer-title{
    font-size:16px;
    font-weight:600;
    margin-bottom:8px;
    color:#2563eb;
}

.answer{
    background:#f1f5f9;
    padding:16px;
    border-radius:10px;
    font-size:15px;
    line-height:1.6;
    white-space:pre-wrap; /* line breaks preserved */
}

/* MOBILE */
@media(max-width:640px){
    body{
        padding:15px;
    }

    .question{
        font-size:16px;
    }

    .answer{
        font-size:14px;
        padding:14px;
    }
}
</style>
</head>
<body>

<div class="container">

   

    <div class="box">

        <!-- QUESTION TEXT -->
        <div class="question">
            <?= htmlspecialchars($data['question']) ?>
        </div>

        <?php if(!empty($data['image'])): ?>
        <div class="question-img">
            <img src="../admin/uploads/<?= htmlspecialchars($data['image']) ?>" alt="Question Image">
        </div>
        <?php endif; ?>


        <!-- ANSWER -->
        <div class="answer-title">Answer</div>
        <div class="answer">
            <?= htmlspecialchars($data['answer']) ?>
        </div>

    </div>

</div>

</body>
</html>
