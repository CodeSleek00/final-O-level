<?php
include("../db_connect.php");

// Fetch distinct subjects
$subjects = $conn->query("SELECT DISTINCT subject FROM practical_questions ORDER BY subject");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Subjects Overview</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
body{font-family:'Poppins',sans-serif;background:#f8fafc;margin:0;padding:30px;color:#1e293b;}
h2{text-align:center;margin-bottom:30px;}
.subject-list{max-width:600px;margin:0 auto;}
.subject-item{
    background:white;padding:15px 20px;margin-bottom:10px;border-radius:10px;
    box-shadow:0 3px 6px rgba(0,0,0,0.1);
    cursor:pointer;
    transition:0.2s;
}
.subject-item:hover{background:#3b82f6;color:white;}
a{text-decoration:none;color:inherit;display:block;}
</style>
</head>
<body>

<h2>Subjects</h2>

<div class="subject-list">
<?php while($row = $subjects->fetch_assoc()): ?>
    <div class="subject-item">
        <a href="subject_questions.php?subject=<?= urlencode($row['subject']) ?>">
            <?= $row['subject'] ?>
        </a>
    </div>
<?php endwhile; ?>
</div>

</body>
</html>
