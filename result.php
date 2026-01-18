<?php
include "db_connect.php";

$answers = $_POST['ans'] ?? [];

$correct=0;
$wrong=0;
$summary = [];

foreach($answers as $qid => $ans){
    $res = $conn->query("SELECT correct_option FROM questions WHERE id=$qid")->fetch_assoc();
    if($res['correct_option'] == $ans){
        $correct++;
        $summary[$qid] = 'Correct';
    }else{
        $wrong++;
        $summary[$qid] = 'Wrong';
    }
}

// Fetch total questions
$total_q = $conn->query("SELECT COUNT(*) as t FROM questions")->fetch_assoc()['t'];

echo "<h2>Exam Result</h2>";
echo "<p>Total Questions: $total_q</p>";
echo "<p>Attempted: ".count($answers)."</p>";
echo "<p>Correct: $correct</p>";
echo "<p>Wrong: $wrong</p>";

echo "<h3>Detailed Summary:</h3>";
echo "<table border='1' cellpadding='8'>";
echo "<tr><th>Q ID</th><th>Status</th></tr>";
foreach($summary as $qid => $status){
    echo "<tr><td>$qid</td><td>$status</td></tr>";
}
echo "</table>";
?>
