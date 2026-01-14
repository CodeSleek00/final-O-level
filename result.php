<?php include "db_connect.php";

foreach($_POST['ans'] as $qid => $user_ans){
    $q = $conn->query("SELECT * FROM questions WHERE id=$qid");
    $row = $q->fetch_assoc();

    echo "<p><b>{$row['question']}</b></p>";
    echo "Your Answer: $user_ans <br>";
    echo "Correct Answer: {$row['correct_option']} <br>";
    echo "<b>Explanation:</b> {$row['explanation']}<hr>";
}
?>
