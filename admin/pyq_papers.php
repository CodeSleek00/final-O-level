<?php
include '../db_connect.php';

/* FETCH SUBJECTS */
$subjects = $conn->query("SELECT id, subject_name FROM subjects ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin | PYQ Papers</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{font-family:Poppins;background:#f4f6f9;margin:0}
.container{max-width:900px;margin:40px auto;background:#fff;padding:25px;border-radius:16px}
input,select,button{padding:10px;width:100%;margin-bottom:10px}
button{background:#0d6efd;color:#fff;border:none;border-radius:6px}
.card{border:1px solid #ddd;padding:15px;border-radius:10px;margin-bottom:10px}
a{color:#2563eb;text-decoration:none;font-size:14px}
</style>
</head>

<body>
<div class="container">

<h2>Add PYQ Paper</h2>

<form method="post" action="pyq_save_paper.php">
    <select name="subject_id" required>
        <option value="">Select Subject</option>
        <?php while($s=$subjects->fetch_assoc()){ ?>
            <option value="<?= $s['id'] ?>">
                <?= htmlspecialchars($s['subject_name']) ?>
            </option>
        <?php } ?>
    </select>

    <input type="text" name="paper_title" placeholder="Paper Title (e.g. IT Tools PYQ)" required>
    <input type="number" name="exam_year" placeholder="Exam Year (e.g. 2023)" required>

    <button type="submit">Add Paper</button>
</form>

<hr>

<h2>Existing PYQ Papers</h2>

<?php
$papers = $conn->query("
    SELECT p.*, s.subject_name 
    FROM pyq_papers p
    JOIN subjects s ON p.subject_id = s.id
    ORDER BY p.exam_year DESC
");

while($p=$papers->fetch_assoc()){
?>
<div class="card">
    <b><?= htmlspecialchars($p['paper_title']) ?></b>
    <br>
    <?= $p['subject_name'] ?> • <?= $p['exam_year'] ?>
    <br><br>
    <a href="pyq_add_questions.php?paper_id=<?= $p['id'] ?>">
        ➕ Add Questions
    </a>
</div>
<?php } ?>

</div>
</body>
</html>
