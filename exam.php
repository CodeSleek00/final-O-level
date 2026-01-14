<?php include "db_connect.php";

$sid   = $_GET['sid'];
$setid = $_GET['setid'];

$q = $conn->query("
    SELECT * FROM questions
    WHERE subject_id=$sid AND set_id=$setid
");
?>

<form action="result.php" method="post">
<?php $i=1; while($row = $q->fetch_assoc()){ ?>
    <p><b>Q<?= $i++ ?>. <?= $row['question'] ?></b></p>

    <input type="radio" name="ans[<?= $row['id'] ?>]" value="A"> <?= $row['option_a'] ?><br>
    <input type="radio" name="ans[<?= $row['id'] ?>]" value="B"> <?= $row['option_b'] ?><br>
    <input type="radio" name="ans[<?= $row['id'] ?>]" value="C"> <?= $row['option_c'] ?><br>
    <input type="radio" name="ans[<?= $row['id'] ?>]" value="D"> <?= $row['option_d'] ?><br><br>
<?php } ?>

<button type="submit">Submit Exam</button>
</form>
