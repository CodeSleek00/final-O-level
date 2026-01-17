<?php
include '../db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Mock Tests</title>

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
        <h1>All Mock Tests – Practice Here</h1>
        <p>Web, IoT, Python, and all subjects in one place</p>
    </div>

<?php
// FETCH ALL SUBJECTS
$subjects = $conn->query("SELECT * FROM subjects ORDER BY id ASC");

if($subjects && $subjects->num_rows > 0){
    while($sub = $subjects->fetch_assoc()){
?>

    <div class="subject-box">
        <div class="subject-title">
            <?= htmlspecialchars($sub['subject_name']); ?>
        </div>

        <div class="mock-grid">

        <?php
        // FETCH TEST SETS FOR THIS SUBJECT
        $sets = $conn->query("SELECT * FROM test_sets WHERE subject_id = ".intval($sub['id'])." ORDER BY id ASC");

        if($sets && $sets->num_rows > 0){
            while($set = $sets->fetch_assoc()){

                $totalQRes = $conn->query("SELECT COUNT(*) AS total FROM questions WHERE set_id = ".intval($set['id']));
                $totalQ = $totalQRes ? $totalQRes->fetch_assoc() : ['total' => 0];
        ?>

            <div class="mock-card">
                <h3><?= htmlspecialchars($set['set_name']); ?></h3>
                <p>Total Questions: <b><?= $totalQ['total']; ?></b></p>

                <a class="start-btn"
                   href="../exam.php?sid=<?= intval($sub['id']); ?>&setid=<?= intval($set['id']); ?>">
                   Start Mock Test
                </a>
            </div>

        <?php 
            } // end sets loop
        } else {
            echo "<p>No mock tests available for this subject.</p>";
        }
        ?>

        </div>
    </div>

<?php 
    } // end subjects loop
} else {
    echo "<p>No subjects found.</p>";
}
?>

</div>

</body>
</html>
