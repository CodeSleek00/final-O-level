<?php
include '../db_connect.php';
$subject_id = 1; // IT Tools (M1-R5)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M1-R5 (IT Tools)</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">


    <style>
        body{
            font-family: 'Poppins', sans-serif;
            background:#f4f6f9;
            margin:0;
        }
      /* Container */
.container{
    max-width:1200px;
    margin:50px auto;
    padding:0 20px;
}
.container h1{
    font-size:20px;
    margin-bottom:30px;
    color:#222;
    text-align: center;
    font-weight: bold;
}

/* Grid Layout */
.cards-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr); /* Mobile default: 2 cards per row */
    gap:25px;
}

/* Card Style */
.test-card{
    background:#fff;
    border-radius:3px;
    padding:25px;
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
    text-align:center;
    transition:.3s;
}

.test-card:hover{
    transform:translateY(-5px);
    box-shadow:0 18px 40px rgba(0,0,0,0.12);
}

.test-card h1{
    font-size:20px;
    margin-bottom:10px;
    color:#222;
}

.test-card p{
    font-size:14px;
    color:#555;
    margin-bottom:20px;
}

.start-btn{
    display:inline-block;
    padding:12px 25px;
    background:#0d6efd;
    color:#fff;
    border-radius:5px;
    text-decoration:none;
    font-weight:500;
    transition:.3s;
}

.start-btn:hover{
    background:#084298;
}

/* Laptop/Desktop: 4 cards per row */
@media(min-width:1024px){
    .cards-grid{
        grid-template-columns:repeat(4,1fr);
    }
}

        /* ===== PAGE WRAPPER ===== */
        .page-wrapper {
            max-width: 1200px;
            margin: auto;
            padding-left: 20px;
            padding-right: 20px;
            padding-top: 20px;
        }

        /* ===== HEADER ===== */
        header {
            text-align: center;
            margin-bottom: 40px;
        }

        header h2 {
            font-size: 22px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 6px;
        }

        header p {
            font-size: 14px;
            color: var(--text-light);
        }

        /* ===== BANNER ===== */
        .it-banner {
            background: url('../image/bg.svg');
            background-size: cover;
            background-position: center center;
            padding: 40px 40px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            text-align: center;
            margin-bottom: 50px;
            background-color: black;
            color: white;
        }
        

        .tag {
            display: inline-block;
            padding: 6px 18px;
            background: #eef2ff;
            color: var(--primary);
            font-size: 13px;
            font-weight: 600;
            border-radius: 20px;
            margin-bottom: 18px;
        }

        .it-banner h1 {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .it-banner p {
            font-size: 17px;
            line-height: 1.7;
            color: rgb(171, 171, 171);
            max-width: 800px;
            margin: auto;
        }

        .cta-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 14px 34px;
            background: var(--primary);
            color: #fff;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .cta-btn:hover {
            background: #1e40af;
            transform: translateY(-2px);
        }

        /* ===== FEATURES ===== */
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 5px;
        }

        .feature-box {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.05);
            text-align: center;
        }

        .feature-box h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .feature-box p {
            font-size: 14px;
            color: var(--text-light);
            line-height: 1.6;
        }

        /* ===== FOOTER ===== */
        footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: var(--text-light);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .features {
                grid-template-columns: 1fr;
            }

            .it-banner h1 {
                font-size: 34px;
            }
             .features {
                display: none;
            }
             .it-banner {
                margin-bottom: 0px;
            }
        }

        @media (max-width: 480px) {
            .it-banner {
                padding: 40px 25px;
                margin-bottom: 0px;
            }

            .it-banner h1 {
                font-size: 30px;
            }

            .it-banner p {
                font-size: 16px;
            }
            .features {
                display: none;
            }
            .start-btn{
                padding: 10px 10px;
             }
             .test-card {
                padding: 15px;
             }

        }
    </style>
</head>

<body>

<?php include '../navbar.html'; ?>

<div class="page-wrapper">

   

    <!-- BANNER -->
    <section class="it-banner">
        
        <h1>IT Tools MCQ Practice</h1>
        <p>
            Practice updated MCQs based on the latest NIELIT syllabus.
            Improve accuracy, speed, and confidence with topic-wise
            IT Tools questions designed for O Level students.
        </p>
        
    </section>

    <!-- FEATURES -->
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
<div class="container">

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


</body>
</html>
