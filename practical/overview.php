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
    padding:20px;
    margin:0;
}

/* PAGE TITLE */
h2{
    text-align:center;
    margin-bottom:25px;
    font-size:22px;
    font-weight:600;
    color:#0f172a;
}

/* GRID */
.subject-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:18px;
    max-width:1000px;
    margin:auto;
}

/* CARD */
.subject-card{
    background:white;
    border-radius:14px;
    padding:20px;
    border:1px solid #e5e7eb;
    transition:0.25s;
}

/* DESKTOP HOVER */
@media (hover:hover){
    .subject-card:hover{
        border-color:#2563eb;
        box-shadow:0 8px 20px rgba(37,99,235,0.12);
        transform:translateY(-4px);
    }
}

/* TITLE */
.subject-title{
    font-size:17px;
    font-weight:600;
    color:#0f172a;
    margin-bottom:6px;
}

/* SUBTEXT */
.subject-meta{
    font-size:14px;
    color:#64748b;
    margin-bottom:14px;
}

/* BUTTON */
.btn{
    display:inline-block;
    padding:9px 16px;
    font-size:14px;
    border-radius:8px;
    text-decoration:none;
    border:1px solid #2563eb;
    color:#2563eb;
    transition:0.2s;
}

/* DESKTOP HOVER */
@media (hover:hover){
    .btn:hover{
        background:#2563eb;
        color:white;
    }
}

/* ---------- MOBILE UI ---------- */
@media(max-width:640px){

    h2{
        font-size:20px;
        margin-bottom:20px;
    }

    .subject-grid{
        grid-template-columns:1fr;
        gap:14px;
    }

    .subject-card{
        padding:18px;
    }

    .subject-title{
        font-size:16px;
    }

    .subject-meta{
        font-size:13px;
    }

    .btn{
        width:100%;
        text-align:center;
        padding:11px;
        font-size:15px;
        border-radius:10px;
    }
}
</style>
</head>
<body>

<h2>Practical Subjects</h2>

<div class="subject-grid">

<?php while($row = $subjects->fetch_assoc()): ?>
<div class="subject-card">
    <div class="subject-title"><?= htmlspecialchars($row['subject']) ?></div>
    <div class="subject-meta">Chapter-wise practical questions</div>
    <a class="btn" href="subject_questions.php?subject=<?= urlencode($row['subject']) ?>">
        View Questions →
    </a>
</div>
<?php endwhile; ?>

</div>

</body>
</html>
