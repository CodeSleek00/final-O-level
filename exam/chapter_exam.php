<?php
include '../db_connect.php';

// Get selected subject
$selected_subject_id = isset($_GET['subject']) ? intval($_GET['subject']) : 0;

// Fetch subject info
$subject = $conn->query("SELECT * FROM subjects WHERE id = $selected_subject_id")->fetch_assoc();
if(!$subject){
    die("<p style='text-align:center; margin-top:50px; font-size:18px; color:red;'>Invalid Subject. <a href='all_subjects.php'>Go Back</a></p>");
}

// Fetch chapters with at least 1 question
$chapters = $conn->query("
    SELECT c.id, c.chapter_name, COUNT(q.id) AS total_questions
    FROM chapters c
    LEFT JOIN chapter_questions q ON c.id = q.chapter_id AND c.subject_id = q.subject_id
    WHERE c.subject_id = $selected_subject_id
    GROUP BY c.id
    HAVING total_questions > 0
    ORDER BY c.id ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($subject['subject_name']); ?> Chapters</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body { font-family:'Poppins',sans-serif; background:#f4f6f9; margin:0; padding:0;}
.container { max-width:900px; margin:50px auto; padding:20px; background:#fff; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,.08);}
h2 { margin-bottom:5px; }
.subtitle { color:#666; font-size:14px; margin-bottom:20px; }
.chapter-table { width:100%; border-collapse:collapse; }
.chapter-table tr { border-bottom:1px solid #eee; transition:0.2s; }
.chapter-table tr:hover { background:#f0f4ff; }
.chapter-table td { padding:15px; vertical-align:middle; }
.chapter-name { font-weight:500; font-size:16px; color:#1e40af; }
.start-btn { background:#4f46e5; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:500; transition:0.3s; display:inline-block;}
.start-btn:hover { background:#6366f1; }
@media (max-width:600px){
    .chapter-table td { display:block; width:100%; padding:10px 0; text-align:center; }
    .start-btn { width:80%; margin-top:5px; }
}
</style>
</head>
<body>

<div class="container">
<h2><?= htmlspecialchars($subject['subject_name']); ?> Chapters</h2>
<div class="subtitle">Click Start Exam to practice chapter-wise questions</div>

<?php if($chapters->num_rows > 0): ?>
<table class="chapter-table">
<?php while($ch = $chapters->fetch_assoc()): ?>
<tr>
    <td class="chapter-name"><?= htmlspecialchars($ch['chapter_name']); ?> (<?= $ch['total_questions']; ?> Qs)</td>
    <td style="text-align:right;"><a class="start-btn" href="chapter_exam.php?chapter_id=<?= $ch['id']; ?>">Start Exam</a></td>
</tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p style="text-align:center; margin-top:30px;">No chapters with questions found for this subject.</p>
<?php endif; ?>

</div>
</body>
</html>
