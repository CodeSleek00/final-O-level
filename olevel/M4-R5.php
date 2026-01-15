<?php
include '../db_connect.php';
$subject_id = 4; // IOT M4-R5
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M4-R5 (Internet of Things)</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

</head>

<body>

<?php include 'navbar.html'; ?>

<div class="page-wrapper">

   

    <!-- BANNER -->
    <section class="it-banner">
        
        <h1>Internet of Things MCQ Practice</h1>
        <p>
            Practice updated MCQs based on the latest NIELIT syllabus.
            Improve accuracy, speed, and confidence with topic-wise
            Internet of Things questions designed for O Level students.
        </p>
        
    </section>

    <!-- FEATURES -->
    <section class="features">
        <div class="feature-box">
            <h3>📘 Updated Syllabus</h3>
            <p>MCQs strictly based on latest NIELIT O Level M4-R5 syllabus.</p>
        </div>

        <div class="feature-box">
            <h3>📝 Topic-wise Practice</h3>
            <p>Practice Internet of Things, Sensors, and Networking topics.</p>
        </div>

        <div class="feature-box">
            <h3>⏱ Exam-Oriented</h3>
            <p>Designed to improve speed, accuracy, and exam confidence.</p>
        </div>
    </section>
</div>

<div class="container">
    <h1>Chapter-wise Practice</h1>
<div class="cards-grid">

<?php
$q = $conn->query("SELECT * FROM chapters WHERE subject_id=$subject_id");
while($ch = $q->fetch_assoc()){

$count = $conn->query("
    SELECT COUNT(*) total 
    FROM chapter_questions 
    WHERE chapter_id={$ch['id']}
")->fetch_assoc();
?>

<div class="test-card">
    <h3><?= $ch['chapter_name']; ?></h3>
    <p>Total Questions: <b><?= $count['total']; ?></b></p>

    <a class="start-btn"
       href="../exam/chapter_exam.php?cid=<?= $ch['id']; ?>">
       Start Practice
    </a>
</div>

<?php } ?>

</div>
</div>


<div class="container">
 <h1>Mock Test</h1>
    <div class="cards-grid">
        <?php
        $q = $conn->query("SELECT * FROM test_sets WHERE subject_id=$subject_id");
        while($row = $q->fetch_assoc()){

            $countQ = $conn->query("
                SELECT COUNT(*) AS total 
                FROM questions 
                WHERE set_id={$row['id']}
            ")->fetch_assoc();
        ?>
            <div class="test-card">
                <h1><?= $row['set_name']; ?></h1>
                <p>This Mock Test Consist : <b><?= $countQ['total']; ?> Questions</b></p>
                <a class="start-btn" href="../exam.php?sid=<?= $subject_id; ?>&setid=<?= $row['id']; ?>">Start Exam</a>
            </div>
        <?php } ?>
    </div>

</div>


</body>
</html>
