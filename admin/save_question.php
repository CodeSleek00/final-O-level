<?php
include("../db_connect.php");

$subject  = $_POST['subject'];
$chapter  = $_POST['chapter'];
$question = $_POST['question'];
$answer   = $_POST['answer'];

$sql = "INSERT INTO practical_questions (subject, chapter, question, answer)
        VALUES ('$subject', '$chapter', '$question', '$answer')";

$conn->query($sql);

header("Location: add_practical_question.php?success=1");
