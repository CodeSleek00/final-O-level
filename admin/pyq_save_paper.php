<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_home.php');
    exit();
}

include '../db_connect.php';

$subject_id = intval($_POST['subject_id']);
$title = trim($_POST['paper_title']);
$year  = intval($_POST['exam_year']);

if(empty($title) || $subject_id <= 0 || $year <= 2000){
    header("Location: pyq_papers.php?error=invalid");
    exit;
}

$stmt = $conn->prepare("INSERT INTO pyq_papers (subject_id, paper_title, exam_year) VALUES (?, ?, ?)");
$stmt->bind_param("isi", $subject_id, $title, $year);

if($stmt->execute()){
    header("Location: pyq_papers.php?success=1");
} else {
    header("Location: pyq_papers.php?error=1");
}
exit;
