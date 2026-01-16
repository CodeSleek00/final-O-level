<?php
include("../db_connect.php");

// Get subject from URL
$subject = $_GET['subject'] ?? '';
if(!$subject){
    echo "Invalid Subject"; exit;
}

// Fetch all questions for this subject
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
.chapter-title{font-weight:600;margin-top:20px;color:#2563eb;}
.question-item{
    background:white;padding:12px 16px;margin:10px 0;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.05);
    cursor:pointer;
    transition:0.2s;
}
.question-item:hover{background:#e2e8f0;}
.answer-box{
    display:none;
    background:#f1f5f9;
    padding:10px 15px;
    border-left:3px solid #3b82f6;
    margin-top:5px;
    font-family:monospace;
    white-space: pre-wrap;
}
.back-link{
    display:inline-block;margin-bottom:20px;color:#3b82f6;
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
    <div class="question-item" onclick="toggleAnswer(this)">
        <?= htmlspecialchars($q['question']) ?>
        <div class="answer-box"><?= htmlspecialchars($q['answer']) ?></div>
    </div>
<?php endwhile; ?>

<script>
function toggleAnswer(el){
    const ans = el.querySelector('.answer-box');
    if(ans.style.display === 'block'){
        ans.style.display = 'none';
    } else {
        ans.style.display = 'block';
    }
}
</script>

</body>
</html>
