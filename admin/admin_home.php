<?php
include "../db_connect.php";

// ===== COUNTS =====
$subjects = $conn->query("SELECT COUNT(*) total FROM subjects")->fetch_assoc()['total'];
$sets = $conn->query("SELECT COUNT(*) total FROM test_sets")->fetch_assoc()['total'];
$mcqs = $conn->query("SELECT COUNT(*) total FROM questions")->fetch_assoc()['total'];
$chapters = $conn->query("SELECT COUNT(*) total FROM chapters")->fetch_assoc()['total'];
$chapter_q = $conn->query("SELECT COUNT(*) total FROM chapter_questions")->fetch_assoc()['total'];
$practicals = $conn->query("SELECT COUNT(*) total FROM practical_questions")->fetch_assoc()['total'];
$shortcut_cat = $conn->query("SELECT COUNT(*) total FROM shortcut_categories")->fetch_assoc()['total'];
$shortcuts = $conn->query("SELECT COUNT(*) total FROM shortcuts")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body{font-family:Poppins;background:#f4f6f9;margin:0;padding:30px}
h2{margin-bottom:10px}
.dashboard{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px}
.card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}
.card h3{margin:0;font-size:16px;color:#555}
.card p{font-size:26px;margin:8px 0;font-weight:600;color:#0d6efd}
.section{margin-top:40px}
a.btn{
    display:block;
    padding:14px;
    background:#0d6efd;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    text-align:center;
    margin-bottom:12px;
}
</style>
</head>
<body>

<h2>📊 Admin Summary</h2>

<div class="dashboard">
    <div class="card"><h3>Total Subjects</h3><p><?= $subjects ?></p></div>
    <div class="card"><h3>Mock Test Sets</h3><p><?= $sets ?></p></div>
    <div class="card"><h3>Total MCQs</h3><p><?= $mcqs ?></p></div>
    <div class="card"><h3>Total Chapters</h3><p><?= $chapters ?></p></div>
    <div class="card"><h3>Chapter Questions</h3><p><?= $chapter_q ?></p></div>
    <div class="card"><h3>Practical Questions</h3><p><?= $practicals ?></p></div>
    <div class="card"><h3>Shortcut Categories</h3><p><?= $shortcut_cat ?></p></div>
    <div class="card"><h3>Shortcut Keys</h3><p><?= $shortcuts ?></p></div>
</div>

<div class="section">
    <h2>⚙️ Management</h2>
    <a class="btn" href="add_set.php">➕ Add Mock Test Set</a>
    <a class="btn" href="add_question.php">📝 Add MCQ Question</a>

    <h2>📘 Chapter</h2>
    <a class="btn" href="add_chapter.php">➕ Add Chapter</a>
    <a class="btn" href="add_chapter_question.php">➕ Add Chapter Question</a>

    <h2>🧪 Practical</h2>
    <a class="btn" href="add_practical_question.php">➕ Add Practical Question</a>

    <h2>⌨️ Shortcut Keys</h2>
    <a class="btn" href="add_category.php">➕ Shortcut Category</a>
    <a class="btn" href="add_shortcut.php">➕ Shortcut Key</a>
</div>

</body>
</html>
