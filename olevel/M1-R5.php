<?php
include '../db_connect.php';
$subject_id = 1; // IT Tools (M1-R5)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Tools (M1-R5) - MCQ Practice</title>
    
    <!-- External Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #084298;
            --text-light: #555;
            --card-bg: #fff;
            --shadow-light: rgba(0, 0, 0, 0.05);
            --shadow-medium: rgba(0, 0, 0, 0.08);
            --shadow-dark: rgba(0, 0, 0, 0.12);
        }

        /* ===== BASE STYLES ===== */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
            margin: 0;
            color: #222;
            line-height: 1.6;
        }

        /* ===== LAYOUT CONTAINERS ===== */
        .page-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        /* ===== HEADER ===== */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-header h2 {
            font-size: 22px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 6px;
        }

        .page-header p {
            font-size: 14px;
            color: var(--text-light);
        }

        /* ===== BANNER SECTION ===== */
        .hero-banner {
            background: url('../image/bg.svg') center center/cover;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            text-align: center;
            margin-bottom: 50px;
            background-color: #000;
            color: #fff;
        }

        .subject-tag {
            display: inline-block;
            padding: 6px 18px;
            background: #eef2ff;
            color: var(--primary);
            font-size: 13px;
            font-weight: 600;
            border-radius: 20px;
            margin-bottom: 18px;
        }

        .hero-banner h1 {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .hero-banner p {
            font-size: 17px;
            color: #ababab;
            max-width: 800px;
            margin: 0 auto;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-block;
            text-decoration: none;
            font-weight: 500;
            border-radius: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            padding: 12px 25px;
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-large {
            padding: 14px 34px;
            border-radius: 50px;
            font-size: 15px;
            margin-top: 25px;
        }

        /* ===== FEATURES SECTION ===== */
        .features-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 5px;
        }

        .feature-card {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 25px var(--shadow-light);
            text-align: center;
        }

        .feature-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #222;
        }

        .feature-card p {
            font-size: 14px;
            color: var(--text-light);
            line-height: 1.6;
            margin: 0;
        }

        /* ===== TEST CARDS GRID ===== */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .test-card {
            background: var(--card-bg);
            border-radius: 3px;
            padding: 25px;
            box-shadow: 0 12px 30px var(--shadow-medium);
            text-align: center;
            transition: all 0.3s ease;
        }

        .test-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 40px var(--shadow-dark);
        }

        .test-card h1,
        .test-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #222;
        }

        .test-card p {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 20px;
        }

        /* ===== SECTION TITLES ===== */
        .section-title {
            grid-column: 1 / -1;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            color: var(--primary);
            margin: 40px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        /* ===== FOOTER ===== */
        .page-footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: var(--text-light);
            margin-top: 50px;
            border-top: 1px solid #eee;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        
        /* Tablet */
        @media (min-width: 768px) and (max-width: 1023px) {
            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .hero-banner h1 {
                font-size: 34px;
            }
        }

        /* Desktop/Laptop */
        @media (min-width: 1024px) {
            .cards-grid {
                grid-template-columns: repeat(4, 1fr);
            }
            
            .features-section {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Mobile */
        @media (max-width: 767px) {
            .container {
                margin: 30px auto;
                padding: 0 15px;
            }
            
            .hero-banner {
                padding: 30px 20px;
                margin-bottom: 30px;
            }
            
            .hero-banner h1 {
                font-size: 28px;
            }
            
            .hero-banner p {
                font-size: 16px;
            }
            
            .features-section {
                display: none;
            }
            
            .cards-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .test-card {
                padding: 20px;
            }
            
            .btn-primary {
                padding: 10px 20px;
            }
            
            .section-title {
                font-size: 20px;
                margin: 30px 0 15px;
            }
        }

        /* Small Mobile */
        @media (max-width: 480px) {
            .hero-banner {
                padding: 25px 15px;
            }
            
            .hero-banner h1 {
                font-size: 24px;
            }
            
            .test-card {
                padding: 15px;
            }
            
            .btn-primary {
                padding: 8px 16px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <?php include '../navbar.html'; ?>

    <div class="page-wrapper">
        <!-- HERO BANNER -->
        <section class="hero-banner">
            <span class="subject-tag">M1-R5</span>
            <h1>IT Tools MCQ Practice</h1>
            <p>
                Practice updated MCQs based on the latest NIELIT syllabus.
                Improve accuracy, speed, and confidence with topic-wise
                IT Tools questions designed for O Level students.
            </p>
            <a href="#practice-sets" class="btn btn-primary btn-large">Start Practicing</a>
        </section>

        <!-- FEATURES -->
        <section class="features-section">
            <div class="feature-card">
                <h3>📘 Updated Syllabus</h3>
                <p>MCQs strictly based on latest NIELIT O Level M1-R5 syllabus.</p>
            </div>

            <div class="feature-card">
                <h3>📝 Topic-wise Practice</h3>
                <p>Practice MS Word, Excel, PowerPoint, Internet & IT Tools.</p>
            </div>

            <div class="feature-card">
                <h3>⏱ Exam-Oriented</h3>
                <p>Designed to improve speed, accuracy, and exam confidence.</p>
            </div>
        </section>
    </div>

    <!-- MOCK TEST SETS -->
    <div class="container" id="practice-sets">
        <div class="cards-grid">
            <h2 class="section-title">Mock Test Series</h2>
            
            <?php
            $testQuery = $conn->query("SELECT * FROM test_sets WHERE subject_id = $subject_id");
            while($testSet = $testQuery->fetch_assoc()) {
                $countQuery = $conn->query("SELECT COUNT(*) AS total FROM questions WHERE set_id = {$testSet['id']}");
                $questionCount = $countQuery->fetch_assoc();
            ?>
                <div class="test-card">
                    <h3><?= htmlspecialchars($testSet['set_name']); ?></h3>
                    <p>This Mock Test Contains: <b><?= $questionCount['total']; ?> Questions</b></p>
                    <a href="../exam.php?sid=<?= $subject_id; ?>&setid=<?= $testSet['id']; ?>" 
                       class="btn btn-primary">
                        Start Exam
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- CHAPTER-WISE PRACTICE -->
    <div class="container">
        <div class="cards-grid">
            <h2 class="section-title">Chapter-wise Practice</h2>
            
            <?php
            $chapterQuery = $conn->query("SELECT * FROM chapters WHERE subject_id = $subject_id");
            while($chapter = $chapterQuery->fetch_assoc()) {
                $countQuery = $conn->query("SELECT COUNT(*) AS total FROM chapter_questions WHERE chapter_id = {$chapter['id']}");
                $questionCount = $countQuery->fetch_assoc();
            ?>
                <div class="test-card">
                    <h3><?= htmlspecialchars($chapter['chapter_name']); ?></h3>
                    <p>Total Questions: <b><?= $questionCount['total']; ?></b></p>
                    <a href="../exam/chapter_exam.php?cid=<?= $chapter['id']; ?>" 
                       class="btn btn-primary">
                        Start Practice
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

</body>
</html>