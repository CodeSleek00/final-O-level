<?php include "db_connect.php"; ?>
<h2>Select Subject</h2>

<?php
$q = $conn->query("SELECT * FROM subjects");
while($s = $q->fetch_assoc()){
    echo "<a href='sets.php?sid={$s['id']}'>{$s['subject_name']}</a><br>";
}
?>
