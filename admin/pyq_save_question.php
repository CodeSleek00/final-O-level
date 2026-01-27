<?php
include '../db_connect.php';

$conn->query("
    INSERT INTO pyq_questions
    (paper_id, question, option_a, option_b, option_c, option_d, correct_option, explanation)
    VALUES (
        '".intval($_POST['paper_id'])."',
        '".$conn->real_escape_string($_POST['question'])."',
        '".$conn->real_escape_string($_POST['option_a'])."',
        '".$conn->real_escape_string($_POST['option_b'])."',
        '".$conn->real_escape_string($_POST['option_c'])."',
        '".$conn->real_escape_string($_POST['option_d'])."',
        '".$conn->real_escape_string($_POST['correct_option'])."',
        '".$conn->real_escape_string($_POST['explanation'])."'
    )
");

header("Location: pyq_add_questions.php?paper_id=".$_POST['paper_id']);
exit;
?>