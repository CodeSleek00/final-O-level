<?php
include("../db_connect.php");
$subjects = $conn->query("SELECT DISTINCT subject FROM practical_questions ORDER BY subject");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Subjects</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Poppins',sans-serif;
    background:#f8fafc;
    padding:30px;
}

/* GRID */
.subject-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:20px;
    max-width:1000px;
    margin:auto;
}

/* CARD */
.subject-card{
    background:white;
    border-radius:14px;
    padding:22px;
    border:1px solid #e5e7eb;
    transition:0.25s;
}

.subject-card:hover{
    border-color:#2563eb;
    box-shadow:0 8px 20px rgba(37,99,235,0.12);
    transform:translateY(-4px);
}

/* TITLE */
.subject-title{
    font-size:18px;
    font-weight:600;
    color:#0f172a;
    margin-bottom:8px;
}

/* SUBTEXT */
.subject-meta{
    font-size:14px;
    color:#64748b;
    margin-bottom:16px;
}

/* BUTTON */
.btn{
    display:inline-block;
    padding:8px 16px;
    font-size:14px;
    border-radius:8px;
    text-decoration:none;
    border:1px solid #2563eb;
    color:#2563eb;
    transition:0.2s;
}

.btn:hover{
    background:#2563eb;
    color:white;
}
</style>
</head>
<body>

<h2 style="text-align:center;margin-bottom:30px;">Practical Subjects</h2>

<div class="subject-grid">

<?php while($row = $subjects->fetch_assoc()): ?>
<div class="subject-card">
    <div class="subject-title"><?= htmlspecialchars($row['subject']) ?></div>
    <div class="subject-meta">Chapter-wise practical questions</div>
    <a class="btn" href="subject_questions.php?subject=<?= urlencode($row['subject']) ?>">
        View →
    </a>
</div>
<?php endwhile; ?>

</div>

</body>
</html>
