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
    background:#f1f5f9;
    padding:30px;
}

/* GRID */
.subject-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:24px;
    max-width:1100px;
    margin:auto;
}

/* CARD */
.subject-card{
    position:relative;
    border-radius:18px;
    overflow:hidden;
    background:white;
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
    transition:.35s;
}

.subject-card:hover{
    transform:translateY(-6px);
}

/* FAKE IMAGE AREA */
.fake-image{
    height:130px;
    background:linear-gradient(135deg,#2563eb,#60a5fa);
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
}

/* subtle pattern */
.fake-image::after{
    content:"";
    position:absolute;
    inset:0;
    background:
      radial-gradient(circle at 20% 20%, rgba(255,255,255,.25), transparent 40%),
      radial-gradient(circle at 80% 30%, rgba(255,255,255,.2), transparent 45%);
}

/* BIG SUBJECT TEXT (acts like image) */
.fake-image span{
    font-size:28px;
    font-weight:600;
    color:white;
    z-index:1;
    text-transform:uppercase;
    letter-spacing:1px;
}

/* BODY */
.card-body{
    padding:20px;
    text-align:center;
}

.card-body p{
    font-size:14px;
    color:#64748b;
    margin-bottom:18px;
}

.btn{
    display:inline-block;
    padding:10px 22px;
    background:#0f172a;
    color:white;
    border-radius:10px;
    text-decoration:none;
    font-size:14px;
    transition:.2s;
}

.btn:hover{
    background:#2563eb;
}
</style>
</head>
<body>

<h2 style="text-align:center;margin-bottom:35px;">Practical Subjects</h2>

<div class="subject-grid">

<?php while($row = $subjects->fetch_assoc()): ?>
<div class="subject-card">

    <!-- IMAGE LOOK ALIKE -->
    <div class="fake-image">
        <span><?= htmlspecialchars($row['subject']) ?></span>
    </div>

    <div class="card-body">
        <p>Chapter wise practical questions</p>
        <a class="btn" href="subject_questions.php?subject=<?= urlencode($row['subject']) ?>">
            Open →
        </a>
    </div>

</div>
<?php endwhile; ?>

</div>

</body>
</html>
