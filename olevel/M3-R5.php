<?php
include '../db_connect.php';
$subject_id = 3; // PYTHON (M3-R5)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M3-R5 (Python Programming)</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SAME EXISTING CSS -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>

<?php include 'navbar.html'; ?>

<div class="page-wrapper">

    <!-- BANNER -->
    <section class="it-banner">
        <h1>Python Programming MCQ Practice</h1>
        <p>
            Practice updated MCQs based on the latest NIELIT syllabus.
            Improve accuracy, speed, and confidence with topic-wise
            Python Programming questions designed for O Level students.
        </p>
    </section>

    <!-- FEATURES -->
    <section class="features">
        <div class="feature-box">
            <h3>📘 Updated Syllabus</h3>
            <p>MCQs strictly based on latest NIELIT O Level M3-R5 syllabus.</p>
        </div>

        <div class="feature-box">
            <h3>📝 Topic-wise Practice</h3>
            <p>Practice Python Programming topics.</p>
        </div>

        <div class="feature-box">
            <h3>⏱ Exam-Oriented</h3>
            <p>Designed to improve speed, accuracy, and exam confidence.</p>
        </div>
    </section>
</div>

<!-- ================= CHAPTER WISE PRACTICE ================= -->
<div class="container">
    <h1>Chapter-wise Practice</h1>

    <div class="cards-grid">
        <?php
        $q = $conn->query("SELECT * FROM chapters WHERE subject_id=$subject_id");

        while ($ch = $q->fetch_assoc()) {

            $count = $conn->query("
                SELECT COUNT(*) AS total
                FROM chapter_questions
                WHERE chapter_id = {$ch['id']}
            ")->fetch_assoc();
        ?>
            <div class="test-card">
                <h3 style="font-weight:normal;"><?= htmlspecialchars($ch['chapter_name']); ?></h3>
                <p>Total Questions: <b><?= $count['total']; ?></b></p>

                <a class="start-btn"
                   href="../exam/chapter_exam.php?cid=<?= $ch['id']; ?>">
                   Start Practice
                </a>
            </div>
        <?php } ?>
    </div>
</div>

<!-- ================= MOCK TEST (FIXED LOGIC) ================= -->
<div class="container">
    <h1>Mock Test</h1>

    <div class="cards-grid">
        <?php
        /*
          Correct logic:
          - questions table
          - subject_id = 3
          - group by set_id
        */
        $tests = $conn->query("
            SELECT set_id, COUNT(*) AS total
            FROM questions
            WHERE subject_id = $subject_id
            GROUP BY set_id
            ORDER BY set_id ASC
        ");

        while ($row = $tests->fetch_assoc()) {
        ?>
            <div class="test-card">
                <h3 style="font-weight:normal;">Mock Test <?= $row['set_id']; ?></h3>

                <p>
                    This Mock Test Consists of
                    <b><?= $row['total']; ?> Questions</b>
                </p>

                <a class="start-btn"
                   href="../exam.php?sid=<?= $subject_id; ?>&setid=<?= $row['set_id']; ?>">
                   Start Exam
                </a>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
