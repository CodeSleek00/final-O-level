<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_home.php');
    exit();
}

include '../db_connect.php';

$paper_id = intval($_POST['paper_id']);
$question = trim($_POST['question']);
$option_a = trim($_POST['option_a']);
$option_b = trim($_POST['option_b']);
$option_c = trim($_POST['option_c']);
$option_d = trim($_POST['option_d']);
$correct = trim($_POST['correct_option']);
$explanation = trim($_POST['explanation'] ?? '');

if(empty($question) || empty($option_a) || empty($option_b) || empty($option_c) || empty($option_d) || empty($correct)){
    header("Location: pyq_add_questions.php?paper_id=$paper_id&error=invalid");
    exit;
}

$stmt = $conn->prepare("INSERT INTO pyq_questions (paper_id, question, option_a, option_b, option_c, option_d, correct_option, explanation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssss", $paper_id, $question, $option_a, $option_b, $option_c, $option_d, $correct, $explanation);

if($stmt->execute()){
    header("Location: pyq_add_questions.php?paper_id=$paper_id&success=1");
} else {
    header("Location: pyq_add_questions.php?paper_id=$paper_id&error=1");
}
exit;
?>