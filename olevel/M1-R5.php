<?php
include '../db_connect.php';

/* ONLY IT TOOLS */
$subject_id = 1; // M1-R5 IT Tools
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO TITLE -->
    <title>M1-R5 IT Tools MCQ Practice | O Level Exam Preparation | NIELIT O Level</title>
    
    <!-- META DESCRIPTION -->
    <meta name="description" content="Free M1-R5 IT Tools MCQ practice questions for NIELIT O Level exam. Practice IT Tools MCQs, chapter-wise questions, and mock tests. Best O Level preparation platform for M1-R5 IT Tools by Faiz Computer Institute.">
    
    <!-- KEYWORDS -->
    <meta name="keywords" content="M1-R5, M1-R5 MCQ, IT Tools, IT Tools MCQ, O Level IT Tools, NIELIT M1-R5, O Level Exam, O Level Preparation, M1-R5 Practice, IT Tools Practice, O Level MCQ, NIELIT O Level, O Level Online Test">
    
    <meta name="author" content="Faiz Computer Institute">
    <meta name="robots" content="index, follow">
    
    <!-- CANONICAL -->
    <link rel="canonical" href="https://www.faizcomputerinstitute.com/olevel/M1-R5.php">
    
    <!-- OPEN GRAPH -->
    <meta property="og:title" content="M1-R5 IT Tools MCQ Practice | O Level Exam Preparation">
    <meta property="og:description" content="Practice M1-R5 IT Tools MCQs for NIELIT O Level exam. Free online practice questions and mock tests.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.faizcomputerinstitute.com/olevel/M1-R5.php">
    <meta property="og:image" content="https://www.faizcomputerinstitute.com/image/olevel.png">
    
    <!-- TWITTER -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="M1-R5 IT Tools MCQ Practice | O Level">
    <meta name="twitter:description" content="Free M1-R5 IT Tools MCQ practice for NIELIT O Level exam preparation.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../image/olevel.png">

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
            <p>LibreOffice Writer, Calc, Impress, Internet & IT Tools.</p>
        </div>

        <div class="feature-box">
            <h3>⏱ Exam-Oriented</h3>
            <p>Designed to improve speed, accuracy, and exam confidence.</p>
        </div>
    </section>

</div>

<!-- ================= CHAPTER WISE PRACTICE ================= -->
<div class="container">
    <h1 style="font-weight:normal;">Chapter-wise Practice</h1>

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
                <h3 style="font-weight:normal;"><?= htmlspecialchars($ch['chapter_name']); ?></h3>

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
    <h1 style="font-weight:normal;">Mock Test</h1>

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
                <h3 style="font-weight:normal;">Mock Test <?= $row['set_id']; ?></h3>

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
<!-- ================= PREVIOUS YEAR QUESTIONS ================= -->
<div class="container">
    <h1 style="font-weight:normal;">Previous Year Questions (PYQ)</h1>

    <div class="cards-grid">
        <?php
        $pyq = $conn->query("
            SELECT p.id, p.paper_title, p.exam_year, 
                   COUNT(q.id) AS total_questions
            FROM pyq_papers p
            LEFT JOIN pyq_questions q ON p.id = q.paper_id
            WHERE p.subject_id = $subject_id
            GROUP BY p.id
            HAVING total_questions > 0
            ORDER BY p.exam_year DESC
        ");

        if ($pyq && $pyq->num_rows > 0) {
            while ($row = $pyq->fetch_assoc()) {
        ?>
            <div class="test-card">
                <h3 style="font-weight:normal;">
                    <?= htmlspecialchars($row['paper_title']); ?>
                </h3>

                <p>
                    Year:
                    <b><?= $row['exam_year']; ?></b>
                </p>

                <p>
                    Total Questions:
                    <b><?= $row['total_questions']; ?></b>
                </p>

                <a class="start-btn"
                   href="../exam/pyq_practice.php?paper_id=<?= $row['id']; ?>">
                    Start PYQ Practice
                </a>
            </div>
        <?php
            }
        } else {
            echo "<p style='color:#666'>No previous year questions available.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
