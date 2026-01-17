<?php
include '../db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Subjects MCQ Practice</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Custom CSS -->
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

<?php include 'navbar.html'; ?>

<div class="page-wrapper">

    <div class="main-heading">
        <h1>MCQ Practice – All Subjects</h1>
        <p>Practice Web, IoT, Python, IT Tools and all other subjects in one place</p>
    </div>

<?php
// Fetch all subjects
$subjects = $conn->query("SELECT * FROM subjects ORDER BY id ASC");

if($subjects && $subjects->num_rows > 0){
    while($sub = $subjects->fetch_assoc()){
        $subject_id = intval($sub['id']);
?>

    <!-- ================= SUBJECT BANNER ================= -->
    <section class="subject-banner">
        <h2><?= htmlspecialchars($sub['subject_name']); ?> Practice</h2>
    </section>

    <!-- ================= CHAPTER WISE PRACTICE ================= -->
    <div class="container">
        <h3>Chapter-wise Practice</h3>
        <div class="cards-grid">
        <?php
        $chapters = $conn->query("
            SELECT * FROM chapters
            WHERE subject_id = $subject_id
            ORDER BY id ASC
        ");

        if($chapters && $chapters->num_rows > 0){
            while($ch = $chapters->fetch_assoc()){
                $count = $conn->query("
                    SELECT COUNT(*) AS total
                    FROM chapter_questions
                    WHERE chapter_id = ".intval($ch['id'])
                )->fetch_assoc();
        ?>
            <div class="test-card">
                <h4><?= htmlspecialchars($ch['chapter_name']); ?></h4>
                <p>Total Questions: <b><?= $count['total']; ?></b></p>
                <a class="start-btn" href="../exam/chapter_exam.php?cid=<?= intval($ch['id']); ?>">
                    Start Practice
                </a>
            </div>
        <?php 
            } // end chapters loop
        } else {
            echo "<p>No chapters available for this subject.</p>";
        }
        ?>
        </div>
    </div>

    <!-- ================= MOCK TEST ================= -->
    <div class="container">
        <h3>Mock Tests</h3>
        <div class="cards-grid">
        <?php
        $tests = $conn->query("
            SELECT set_id, COUNT(*) AS total_questions
            FROM questions
            WHERE subject_id = $subject_id
            GROUP BY set_id
            ORDER BY set_id ASC
        ");

        if($tests && $tests->num_rows > 0){
            while($row = $tests->fetch_assoc()){
        ?>
            <div class="test-card">
                <h4>Mock Test <?= $row['set_id']; ?></h4>
                <p>Total Questions: <b><?= $row['total_questions']; ?></b></p>
                <a class="start-btn" href="../exam.php?sid=<?= $subject_id; ?>&setid=<?= $row['set_id']; ?>">
                    Start Exam
                </a>
            </div>
        <?php 
            } // end tests loop
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
