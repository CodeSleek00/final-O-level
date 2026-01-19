<?php
include("../db_connect.php");

$subject = $_GET['subject'] ?? '';
if(!$subject){
    echo "Invalid Subject"; exit;
}

$questions = $conn->query("
    SELECT * 
    FROM practical_questions 
    WHERE subject='{$subject}' 
    ORDER BY chapter, id
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($subject) ?> – Practical Questions</title>
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
.back-link{
    display:inline-block;
    margin-bottom:15px;
    color:#2563eb;
    text-decoration:none;
    font-size:14px;
}

/* HEADER */
.page-title{
    font-size:22px;
    font-weight:600;
    margin-bottom:25px;
    text-align:center;
}

/* CHAPTER */
.chapter-title{
    margin-top:30px;
    margin-bottom:10px;
    font-size:16px;
    font-weight:600;
    color:#2563eb;
    border-left:4px solid #2563eb;
    padding-left:10px;
}

/* QUESTION CARD */
.question-item{
    background:white;
    padding:14px 18px;
    margin-bottom:10px;
    border-radius:10px;
    border:1px solid #e5e7eb;
    cursor:pointer;
    transition:0.2s;
    font-size:15px;
}

.question-item:hover{
    background:#f1f5ff;
    border-color:#2563eb;
}

/* MOBILE */
@media(max-width:640px){
    body{
        padding:15px;
    }

    .page-title{
        font-size:20px;
    }

    .question-item{
        font-size:14px;
        padding:14px;
    }
}
</style>
</head>
<body>

<div class="container">

    <a class="back-link" href="overview_subjects.php">← Back to Subjects</a>

    <div class="page-title">
        <?= htmlspecialchars($subject) ?> – Practical Questions
    </div>

<?php
$currentChapter = '';
while($q = $questions->fetch_assoc()):
    if($currentChapter !== $q['chapter']):
        $currentChapter = $q['chapter'];
?>
    <div class="chapter-title">
        <?= htmlspecialchars($currentChapter) ?>
    </div>
<?php endif; ?>

    <div class="question-item"
         onclick="window.location.href='answer.php?id=<?= $q['id'] ?>'">
        <?= htmlspecialchars($q['question']) ?>
    </div>

<?php endwhile; ?>

</div>

</body>
</html>
