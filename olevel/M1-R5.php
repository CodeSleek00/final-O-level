<?php
include '../db_connect.php';

/* ONLY IT TOOLS SUBJECT */
$subject_id = 1; // M1-R5 IT Tools
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M1-R5 | IT Tools MCQ Practice</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>

<?php include 'navbar.html'; ?>

<!-- ================= BANNER ================= -->
<section class="it-banner">
    <h1>IT Tools MCQ Practice</h1>
    <p>
        Practice chapter-wise MCQs and full mock tests  
        based on latest NIELIT O Level M1-R5 syllabus.
    </p>
</section>

<!-- ================= FEATURES ================= -->
<section class="features">
    <div class="feature-box">
        <h3>📘 Updated Syllabus</h3>
        <p>As per latest NIELIT O Level (M1-R5).</p>
    </div>

    <div class="feature-box">
        <h3>📝 Chapter-wise Practice</h3>
        <p>LibreOffice, Internet & IT Tools MCQs.</p>
    </div>

    <div class="feature-box">
        <h3>⏱ Exam Pattern</h3>
        <p>Real exam oriented questions.</p>
    </div>
</section>

<!-- ================= CHAPTER WISE PRACTICE ================= -->
<div class="container">
    <h1>Chapter-wise Practice</h1>

    <div class="cards-grid">
        <?php
        $chapters = $conn->query("
            SELECT id, chapter_name 
            FROM chapters 
            WHERE subject_id = 1 
            ORDER BY id ASC
        ");

        if ($chapters && $chapters->num_rows > 0) {

            while ($ch = $chapters->fetch_assoc()) {

                $countRes = $conn->query("
                    SELECT COUNT(*) AS total 
                    FROM chapter_questions 
                    WHERE chapter_id = {$ch['id']}
                ");

                $total = ($countRes) ? $countRes->fetch_assoc()['total'] : 0;
        ?>
            <div class="test-card">
                <h3><?= htmlspecialchars($ch['chapter_name']); ?></h3>
                <p>Total Questions: <b><?= $total; ?></b></p>

                <a class="start-btn"
                   href="../exam/chapter_exam.php?cid=<?= $ch['id']; ?>">
                    Start Practice
                </a>
            </div>
        <?php
            }
        } else {
            echo "<p class='no-data'>No chapters available.</p>";
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
            SELECT set_id, COUNT(*) AS total_questions
            FROM questions
            WHERE subject_id = 1
            GROUP BY set_id
            ORDER BY set_id ASC
        ");

        if ($tests && $tests->num_rows > 0) {

            while ($row = $tests->fetch_assoc()) {
        ?>
            <div class="test-card">
                <h3>Mock Test <?= $row['set_id']; ?></h3>
                <p>Total Questions: <b><?= $row['total_questions']; ?></b></p>

                <a class="start-btn"
                   href="../exam.php?sid=1&setid=<?= $row['set_id']; ?>">
                    Start Exam
                </a>
            </div>
        <?php
            }
        } else {
            echo "<p class='no-data'>No mock tests available.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
