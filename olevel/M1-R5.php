<?php
include '../db_connect.php';

/* SUBJECT ID */
$subject_id = 1; // IT Tools (M1-R5)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M1-R5 (IT Tools)</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

    <style>
        body{font-family:Poppins;}
        .cards-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
            gap:20px;
        }
        .test-card{
            background:#fff;
            padding:20px;
            border-radius:14px;
            box-shadow:0 10px 25px rgba(0,0,0,.08);
            transition:.3s;
        }
        .test-card:hover{
            transform:translateY(-5px);
        }
        .start-btn{
            display:inline-block;
            margin-top:15px;
            padding:10px 18px;
            background:#2563eb;
            color:#fff;
            border-radius:8px;
            font-weight:500;
        }
    </style>
</head>

<body class="bg-gray-50">

<?php include 'navbar.html'; ?>

<div class="page-wrapper">

    <!-- ================= BANNER ================= -->
    <section class="it-banner text-center py-14 bg-blue-600 text-white">
        <h1 class="text-3xl font-bold mb-3">IT Tools MCQ Practice</h1>
        <p class="max-w-2xl mx-auto text-sm opacity-90">
            Practice updated MCQs based on the latest NIELIT syllabus.
            Improve accuracy, speed, and confidence with topic-wise IT Tools questions.
        </p>
    </section>

    <!-- ================= FEATURES ================= -->
    <section class="features py-12 bg-white">
        <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-6 px-4">

            <div class="feature-box p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">📘 Updated Syllabus</h3>
                <p>MCQs strictly based on latest NIELIT O Level M1-R5 syllabus.</p>
            </div>

            <div class="feature-box p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">📝 Topic-wise Practice</h3>
                <p>Practice MS Word, Excel, PowerPoint, Internet & IT Tools.</p>
            </div>

            <div class="feature-box p-6 rounded-xl shadow">
                <h3 class="font-semibold text-lg mb-2">⏱ Exam-Oriented</h3>
                <p>Designed to improve speed, accuracy, and exam confidence.</p>
            </div>

        </div>
    </section>

</div>

<!-- ================= CHAPTER WISE PRACTICE ================= -->
<div class="container max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-semibold mb-6">Chapter-wise Practice</h1>

    <div class="cards-grid">
    <?php
    $q = $conn->query("SELECT * FROM chapters WHERE subject_id = $subject_id");
    while($ch = $q->fetch_assoc()){

        $count = $conn->query("
            SELECT COUNT(*) AS total 
            FROM chapter_questions 
            WHERE chapter_id = {$ch['id']}
        ")->fetch_assoc();
    ?>
        <div class="test-card">
            <h3 class="text-lg font-semibold"><?= $ch['chapter_name']; ?></h3>
            <p class="mt-2">Total Questions: <b><?= $count['total']; ?></b></p>

            <a class="start-btn"
               href="../exam/chapter_exam.php?cid=<?= $ch['id']; ?>">
               Start Practice
            </a>
        </div>
    <?php } ?>
    </div>
</div>

<!-- ================= SET WISE MOCK TEST ================= -->
<div class="container max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-semibold mb-6">Mock Test (Set Wise)</h1>

    <div class="cards-grid">

    <?php
    $q = $conn->query("
        SELECT ts.id, ts.set_name,
               COUNT(q.id) AS total_questions
        FROM test_sets ts
        LEFT JOIN questions q ON q.set_id = ts.id
        WHERE ts.subject_id = $subject_id
        GROUP BY ts.id
        ORDER BY ts.id ASC
    ");

    while($row = $q->fetch_assoc()){
    ?>
        <div class="test-card">
            <h3 class="text-xl font-semibold"><?= $row['set_name']; ?></h3>
            <p class="mt-2">
                Total Questions:
                <b><?= $row['total_questions']; ?></b>
            </p>

            <a class="start-btn"
               href="../exam.php?sid=<?= $subject_id; ?>&setid=<?= $row['id']; ?>">
               Start Exam
            </a>
        </div>
    <?php } ?>

    </div>
</div>

</body>
</html>
