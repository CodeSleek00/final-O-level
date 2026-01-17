<?php
include '../db_connect.php';

// SUBJECT ID (change only this)
$subject_id = 1; // M1-R5 (IT Tools)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M1-R5 | IT Tools MCQ Practice</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body class="bg-gray-100 font-[Poppins]">

<?php include 'navbar.html'; ?>

<div class="page-wrapper">

    <!-- ================= BANNER ================= -->
    <section class="it-banner text-center">
        <h1>IT Tools MCQ Practice</h1>
        <p>
            Practice updated MCQs based on the latest NIELIT syllabus.
            Improve accuracy, speed, and confidence with topic-wise
            IT Tools questions designed for O Level students.
        </p>
    </section>

    <!-- ================= FEATURES ================= -->
    <section class="features">
        <div class="feature-box">
            <h3>📘 Updated Syllabus</h3>
            <p>MCQs strictly based on latest NIELIT O Level M1-R5 syllabus.</p>
        </div>

        <div class="feature-box">
            <h3>📝 Topic-wise Practice</h3>
            <p>Practice MS Word, Excel, PowerPoint, Internet & IT Tools.</p>
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
        $chapters = $conn->query("
            SELECT * FROM chapters 
            WHERE subject_id = $subject_id
            ORDER BY id ASC
        ");

        while ($ch = $chapters->fetch_assoc()) {

            $count = $conn->query("
                SELECT COUNT(*) AS total 
                FROM chapter_questions 
                WHERE chapter_id = {$ch['id']}
            ")->fetch_assoc();
        ?>
            <div class="test-card">
                <h3><?= htmlspecialchars($ch['chapter_name']); ?></h3>
                <p>Total Questions: <b><?= $count['total']; ?></b></p>

                <a class="start-btn"
                   href="../exam/chapter_exam.php?cid=<?= $ch['id']; ?>">
                    Start Practice
                </a>
            </div>
        <?php } ?>
    </div>
</div>

<!-- ================= MOCK TEST SECTION ================= -->
<div class="container">
    <h1>Mock Test</h1>

    <div class="cards-grid">
        <?php
        // Sirf subject_id se test fetch honge
        $tests = $conn->query("
            SELECT ts.id, ts.set_name, COUNT(q.id) AS total_questions
            FROM test_sets ts
            LEFT JOIN questions q ON ts.id = q.set_id
            WHERE ts.subject_id = $subject_id
            GROUP BY ts.id
            ORDER BY ts.id ASC
        ");

        while ($test = $tests->fetch_assoc()) {
        ?>
            <div class="test-card">
                <h3><?= htmlspecialchars($test['set_name']); ?></h3>

                <p>
                    Total Questions:
                    <b><?= $test['total_questions']; ?></b>
                </p>

                <a class="start-btn"
                   href="../exam.php?sid=<?= $subject_id; ?>&setid=<?= $test['id']; ?>">
                    Start Exam
                </a>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
