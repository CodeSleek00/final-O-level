<?php
include '../db_connect.php';
$subject_id = 3; // PYTHON (M3-R5)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M3-R5 | Python Programming</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>

<?php include 'navbar.html'; ?>

<div class="page-wrapper">

    <!-- ================= BANNER ================= -->
    <section class="it-banner">
        <h1>Python Programming MCQ Practice</h1>
        <p>
            Practice updated MCQs based on the latest NIELIT O Level syllabus.
            Topic-wise and exam-oriented questions for better accuracy & confidence.
        </p>
    </section>

    <!-- ================= FEATURES ================= -->
    <section class="features">
        <div class="feature-box">
            <h3>📘 Updated Syllabus</h3>
            <p>Strictly based on NIELIT O Level M3-R5 syllabus.</p>
        </div>

        <div class="feature-box">
            <h3>📝 Chapter-wise Practice</h3>
            <p>Each Python chapter covered with MCQs.</p>
        </div>

        <div class="feature-box">
            <h3>⏱ Exam Oriented</h3>
            <p>Improve speed, accuracy & confidence.</p>
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

        if ($chapters->num_rows > 0) {
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
        <?php
            }
        } else {
            echo "<p style='text-align:center;'>No chapters available.</p>";
        }
        ?>
    </div>
</div>

<!-- ================= MOCK TEST ================= -->
<div class="container">
    <h1>Mock Tests</h1>

    <div class="cards-grid">
        <?php
        $tests = $conn->query("
            SELECT set_id, COUNT(*) AS total
            FROM questions
            WHERE subject_id = $subject_id
            GROUP BY set_id
            ORDER BY set_id ASC
        ");

        if ($tests->num_rows > 0) {
            while ($row = $tests->fetch_assoc()) {
        ?>
            <div class="test-card">
                <h3>Mock Test <?= $row['set_id']; ?></h3>
                <p>Total Questions: <b><?= $row['total']; ?></b></p>

                <a class="start-btn"
                   href="../exam.php?sid=<?= $subject_id; ?>&setid=<?= $row['set_id']; ?>">
                    Start Exam
                </a>
            </div>
        <?php
            }
        } else {
            echo "<p style='text-align:center;'>No mock tests available.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
