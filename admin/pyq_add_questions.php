<?php
include '../db_connect.php';

$paper_id = intval($_GET['paper_id']);

$paper = $conn->query("
    SELECT p.*, s.subject_name 
    FROM pyq_papers p
    JOIN subjects s ON p.subject_id = s.id
    WHERE p.id = $paper_id
")->fetch_assoc();

if(!$paper){
    die("Invalid Paper");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add PYQ Questions</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{font-family:Poppins;background:#f4f6f9;margin:0}
.container{max-width:900px;margin:40px auto;background:#fff;padding:25px;border-radius:16px}
input,textarea,select,button{
    width:100%;padding:10px;margin-bottom:10px
}
button{background:#0d6efd;color:#fff;border:none;border-radius:6px}
</style>
</head>

<body>
<div class="container">

<h2><?= $paper['paper_title'] ?> (<?= $paper['exam_year'] ?>)</h2>
<h3>Add Question</h3>

<form method="post" action="pyq_save_question.php">
    <input type="hidden" name="paper_id" value="<?= $paper_id ?>">

    <textarea name="question" placeholder="Question" required></textarea>

    <input type="text" name="option_a" placeholder="Option A" required>
    <input type="text" name="option_b" placeholder="Option B" required>
    <input type="text" name="option_c" placeholder="Option C" required>
    <input type="text" name="option_d" placeholder="Option D" required>

    <select name="correct_option" required>
        <option value="">Correct Option</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
    </select>

    <textarea name="explanation" placeholder="Explanation (optional)"></textarea>

    <button type="submit">Save Question</button>
</form>

<hr>

<h3>Existing Questions</h3>

<?php
$q = $conn->query("
    SELECT question FROM pyq_questions WHERE paper_id=$paper_id
");
$i=1;
while($row=$q->fetch_assoc()){
    echo "<p>$i. ".htmlspecialchars($row['question'])."</p>";
    $i++;
}
?>

</div>
</body>
</html>
