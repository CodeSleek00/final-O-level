<?php
include '../db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>IT Tools Mock Tests</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
    font-family:Poppins, sans-serif;
    background:#f4f6fb;
    margin:0;
}
.page-wrapper{
    max-width:1200px;
    margin:auto;
    padding:30px;
}
.main-heading{
    text-align:center;
    margin-bottom:40px;
}
.main-heading h1{
    font-size:32px;
}
.subject-box{
    background:#fff;
    margin-bottom:30px;
    border-radius:14px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.06);
}
.subject-title{
    font-size:24px;
    margin-bottom:20px;
    border-left:5px solid #2563eb;
    padding-left:12px;
}
.mock-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}
.mock-card{
    background:#f9fafb;
    padding:20px;
    border-radius:12px;
    border:1px solid #e5e7eb;
}
.mock-card h3{
    margin:0 0 10px;
}
.mock-card p{
    font-size:14px;
    color:#555;
}
.start-btn{
    display:inline-block;
    margin-top:15px;
    padding:10px 18px;
    background:#2563eb;
    color:#fff;
    border-radius:8px;
    text-decoration:none;
    font-size:14px;
}
.start-btn:hover{
    background:#1e40af;
}
</style>
</head>

<body>

<?php include 'navbar.html'; ?>

<div class="page-wrapper">

    <div class="main-heading">
        <h1>IT Tools – All Mock Tests</h1>
        <p>Practice all subjects mock tests at one place</p>
    </div>

<?php
/* SUBJECT FETCH */
$subjects = $conn->query("SELECT * FROM subjects");

while($sub = $subjects->fetch_assoc()){
?>

    <div class="subject-box">
        <div class="subject-title">
            <?= $sub['subject_name']; ?>
        </div>

        <div class="mock-grid">

        <?php
        /* MOCK TEST FETCH (PURANA LOGIC) */
        $sets = $conn->query("
            SELECT * FROM test_sets 
            WHERE subject_id = {$sub['id']}
        ");

        if($sets->num_rows == 0){
            echo "<p>No mock tests available.</p>";
        }

        while($set = $sets->fetch_assoc()){

            $totalQ = $conn->query("
                SELECT COUNT(*) AS total 
                FROM questions 
                WHERE set_id = {$set['id']}
            ")->fetch_assoc();
        ?>

            <div class="mock-card">
                <h3><?= $set['set_name']; ?></h3>
                <p>Total Questions: <b><?= $totalQ['total']; ?></b></p>

                <!-- SAME OLD START EXAM LOGIC -->
                <a class="start-btn"
                   href="../exam.php?sid=<?= $sub['id']; ?>&setid=<?= $set['id']; ?>">
                   Start Mock Test
                </a>
            </div>

        <?php } ?>

        </div>
    </div>

<?php } ?>

</div>

</body>
</html>
