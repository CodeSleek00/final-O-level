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

.subject-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:24px;
    max-width:1100px;
    margin:auto;
}

.subject-card{
    background:white;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    overflow:hidden;
    transition:0.3s;
}

.subject-card:hover{
    transform:translateY(-6px);
}

.card-img{
    height:140px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#e5edff;
}

.card-img img{
    max-height:80px;
}

.card-body{
    padding:20px;
    text-align:center;
}

.subject-title{
    font-size:18px;
    font-weight:600;
    margin-bottom:15px;
}

.btn{
    padding:9px 18px;
    background:#2563eb;
    color:white;
    border-radius:8px;
    text-decoration:none;
    font-size:14px;
}
</style>
</head>
<body>

<h2 style="text-align:center;margin-bottom:30px;">Practical Subjects</h2>

<div class="subject-grid">

<?php while($row = $subjects->fetch_assoc()): ?>
<div class="subject-card" data-subject="<?= strtolower($row['subject']) ?>">
    <div class="card-img">
        <img src="" alt="">
    </div>

    <div class="card-body">
        <div class="subject-title"><?= htmlspecialchars($row['subject']) ?></div>
        <a class="btn" href="subject_questions.php?subject=<?= urlencode($row['subject']) ?>">
            Open →
        </a>
    </div>
</div>
<?php endwhile; ?>

</div>

<script>
const imageMap = {
    "HTML": "../image/3.png",
    "python": "assets/python.png",
    "dbms": "assets/dbms.png",
    "c programming": "assets/c.png"
};

document.querySelectorAll(".subject-card").forEach(card=>{
    const subject = card.dataset.subject;
    const img = card.querySelector("img");

    if(imageMap[subject]){
        img.src = imageMap[subject];
    }else{
        img.src = "assets/default.png"; // optional
    }
});
</script>

</body>
</html>
