<?php
include '../db_connect.php';

/* ONLY IT TOOLS */
$subject_id = 2; // M2-R5 Web Designing & Publishing
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M2-R5 | Web Designing & Publishing MCQ Practice</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>

<?php include 'navbar.html'; ?>

<div class="page-wrapper">

    <!-- ================= BANNER ================= -->
    <section class="it-banner">
        <h1>Web Designing & Publishing MCQ Practice</h1>
        <p>
            Practice updated MCQs based on the latest NIELIT syllabus.
            Improve accuracy, speed, and confidence with topic-wise
            Web Designing & Publishing questions designed for O Level students.
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
            <p>HTML,CSS,JS Internet & Web Designing & Publishing.</p>
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
        /* 🔥 FIXED & CORRECT LOGIC (FROM YOUR OTHER PAGE) */
        $chapters = $conn->query("
            SELECT c.id, c.chapter_name, COUNT(q.id) AS total_questions
            FROM chapters c
            LEFT JOIN chapter_questions q 
                ON c.id = q.chapter_id 
                AND q.subject_id = $subject_id
            WHERE c.subject_id = $subject_id
            GROUP BY c.id
            HAVING total_questions > 0
            ORDER BY c.id ASC
        ");

        if ($chapters && $chapters->num_rows > 0) {
            while ($ch = $chapters->fetch_assoc()) {
        ?>
            <div class="test-card">
                <h3><?= htmlspecialchars($ch['chapter_name']); ?></h3>

                <p>
                    Total Questions:
                    <b><?= $ch['total_questions']; ?></b>
                </p>

                <a class="start-btn"
                   href="../exam/chapter_exam.php?chapter_id=<?= $ch['id']; ?>&subject_id=<?= $subject_id; ?>">
                    Start Practice
                </a>
            </div>
        <?php
            }
        } else {
            echo "<p style='color:#666'>No chapters available.</p>";
        }
        ?>
    </div>
</div>

<!-- ================= MOCK TEST ================= -->
<div class="container">
    <h1>Mock Test</h1>

    <div class="cards-grid">
        <?php
        $tests = $conn->query("
            SELECT set_id, COUNT(*) AS total_questions
            FROM questions
            WHERE subject_id = $subject_id
            GROUP BY set_id
            ORDER BY set_id ASC
        ");

        if ($tests && $tests->num_rows > 0) {
            while ($row = $tests->fetch_assoc()) {
        ?>
            <div class="test-card">
                <h3>Mock Test <?= $row['set_id']; ?></h3>

                <p>
                    Total Questions:
                    <b><?= $row['total_questions']; ?></b>
                </p>

                <a class="start-btn"
                   href="../exam.php?sid=<?= $subject_id; ?>&setid=<?= $row['set_id']; ?>">
                    Start Exam
                </a>
            </div>
        <?php
            }
        } else {
            echo "<p style='color:#666'>No mock tests available.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
