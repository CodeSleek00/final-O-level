<?php
include '../db_connect.php';

$subject_id = intval($_GET['subject_id']);

$papers = $conn->query("
    SELECT p.id, p.paper_title, p.exam_year,
    (SELECT COUNT(*) FROM pyq_questions q WHERE q.paper_id = p.id) AS total_q
    FROM pyq_papers p
    WHERE p.subject_id = $subject_id
    ORDER BY p.exam_year DESC
");

if($papers->num_rows==0){
    echo "<p style='grid-column:1/-1;text-align:center;color:#666'>
            No PYQs available
          </p>";
    exit;
}

while($p=$papers->fetch_assoc()){
?>
<div class="card">
    <h3><?= htmlspecialchars($p['paper_title']) ?></h3>
    <p>
        Year: <?= $p['exam_year'] ?><br>
        Questions: <?= $p['total_q'] ?>
    </p>

    <a class="start-btn"
       href="pyq_practice.php?paper_id=<?= $p['id'] ?>">
       Start PYQ
    </a>
</div>
<?php } ?>
