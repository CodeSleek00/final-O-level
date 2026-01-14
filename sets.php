<?php include "db_connect.php";
$sid = $_GET['sid'];
?>

<h2>Select Test Set</h2>

<?php
$q = $conn->query("SELECT * FROM test_sets WHERE subject_id=$sid");
while($set = $q->fetch_assoc()){
    echo "<a href='exam.php?sid=$sid&setid={$set['id']}'>
            {$set['set_name']}
          </a><br>";
}
?>
