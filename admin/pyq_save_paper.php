<?php
include '../db_connect.php';

$subject_id = intval($_POST['subject_id']);
$title = $conn->real_escape_string($_POST['paper_title']);
$year  = intval($_POST['exam_year']);

$conn->query("
    INSERT INTO pyq_papers (subject_id, paper_title, exam_year)
    VALUES ($subject_id, '$title', $year)
");

header("Location: pyq_papers.php");
exit;
