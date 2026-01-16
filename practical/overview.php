<?php
include("../db_connect.php");

// Fetch distinct subjects
$subjects = $conn->query("SELECT DISTINCT subject FROM practical_questions");

// Fetch chapters per subject with question count
$chaptersQuery = $conn->query("
    SELECT subject, chapter, COUNT(*) as qcount 
    FROM practical_questions 
    GROUP BY subject, chapter 
    ORDER BY subject, chapter
");

// Prepare chapters array
$chapters = [];
while($row = $chaptersQuery->fetch_assoc()){
    $chapters[$row['subject']][] = $row;
}

// Total counts
$totalSubjects = $conn->query("SELECT COUNT(DISTINCT subject) as total FROM practical_questions")->fetch_assoc()['total'];
$totalChapters = $conn->query("SELECT COUNT(DISTINCT chapter) as total FROM practical_questions")->fetch_assoc()['total'];
$totalQuestions = $conn->query("SELECT COUNT(*) as total FROM practical_questions")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Practical Questions Overview</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
body{
    font-family: 'Poppins', sans-serif;
    background:#f8fafc;
    color:#1e293b;
    margin:0;
    padding:20px;
}
h2{
    text-align:center;
    margin-bottom:20px;
}
.stats{
    display:flex;
    justify-content:center;
    gap:30px;
    margin-bottom:30px;
}
.stats div{
    background:white;
    padding:20px 30px;
    border-radius:10px;
    box-shadow:0 4px 6px rgba(0,0,0,0.1);
    text-align:center;
}
.stats div h3{
    margin-bottom:10px;
    font-size:1.25rem;
    color:#3b82f6;
}
.subject{
    margin-bottom:20px;
    background:white;
    border-radius:10px;
    padding:15px;
    box-shadow:0 3px 6px rgba(0,0,0,0.05);
}
.subject h3{
    cursor:pointer;
    color:#1e293b;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.chapter-list{
    display:none;
    margin-top:10px;
    padding-left:15px;
}
.chapter{
    margin-bottom:8px;
    cursor:pointer;
}
.questions-list{
    display:none;
    padding-left:20px;
    margin-top:5px;
    color:#475569;
}
.chapter span{
    font-weight:500;
    color:#2563eb;
}
</style>
</head>
<body>

<h2>Practical Questions Overview</h2>

<div class="stats">
    <div>
        <h3><?= $totalSubjects ?></h3>
        <p>Total Subjects</p>
    </div>
    <div>
        <h3><?= $totalChapters ?></h3>
        <p>Total Chapters</p>
    </div>
    <div>
        <h3><?= $totalQuestions ?></h3>
        <p>Total Questions</p>
    </div>
</div>

<?php foreach($subjects as $subjectRow): 
    $subject = $subjectRow['subject'];
?>
<div class="subject">
    <h3 onclick="toggleChapter(this)"><?= $subject ?> <span>▼</span></h3>
    <div class="chapter-list">
        <?php foreach($chapters[$subject] as $ch): ?>
            <div class="chapter" onclick="toggleQuestions(this)">
                <?= $ch['chapter'] ?> (<?= $ch['qcount'] ?> questions)
                <div class="questions-list">
                    <?php
                    $qs = $conn->query("SELECT question FROM practical_questions WHERE subject='{$subject}' AND chapter='{$ch['chapter']}'");
                    while($qRow = $qs->fetch_assoc()){
                        echo "<div>• ".$qRow['question']."</div>";
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>

<script>
function toggleChapter(el){
    const list = el.nextElementSibling;
    if(list.style.display === "block"){
        list.style.display = "none";
    } else {
        list.style.display = "block";
    }
}
function toggleQuestions(el){
    const qlist = el.querySelector(".questions-list");
    if(qlist.style.display === "block"){
        qlist.style.display = "none";
    } else {
        qlist.style.display = "block";
    }
    // stop propagation so chapter click not triggered
    event.stopPropagation();
}
</script>

</body>
</html>
