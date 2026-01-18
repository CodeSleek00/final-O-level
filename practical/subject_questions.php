<?php
include("../db_connect.php");

$subject = $_GET['subject'] ?? '';
if(!$subject){
    echo "Invalid Subject"; exit;
}

$questions = $conn->query("SELECT * FROM practical_questions WHERE subject='{$subject}' ORDER BY chapter, id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($subject) ?> Questions</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
body{font-family:'Poppins',sans-serif;background:#f8fafc;margin:0;padding:30px;color:#1e293b;}
h2{text-align:center;margin-bottom:20px;}
.chapter-title{font-weight:600;margin-top:25px;color:#2563eb;}
.question-item{
    background:white;
    padding:14px 18px;
    margin:10px 0;
    border-radius:8px;
    box-shadow:0 2px 5px rgba(0,0,0,0.05);
    cursor:pointer;
    transition:0.2s;
}
.question-item:hover{
    background:#e0f2fe;
}
.back-link{
    display:inline-block;
    margin-bottom:20px;
    color:#2563eb;
    text-decoration:none;
}
</style>
</head>
<body>

<a class="back-link" href="overview_subjects.php">← Back to Subjects</a>

<h2><?= htmlspecialchars($subject) ?> Questions</h2>

<?php
$currentChapter = '';
while($q = $questions->fetch_assoc()):
    if($currentChapter !== $q['chapter']):
        $currentChapter = $q['chapter'];
        echo "<div class='chapter-title'>{$currentChapter}</div>";
    endif;
?>
    <div class="question-item"
         onclick="window.location.href='view.php?id=<?= $q['id'] ?>'">
        <?= htmlspecialchars($q['question']) ?>
    </div>
<?php endwhile; ?>

</body>
</html>
