<?php
include("../db_connect.php");

$subject  = $_POST['subject'];
$question = $_POST['question'];
$answer   = $_POST['answer'];

$stmt = $conn->prepare("
    INSERT INTO practical_question (subject, question, answer)
    VALUES (?,?,?)
");
$stmt->bind_param("sss", $subject, $question, $answer);
$stmt->execute();

header("Location: add_question.php");
