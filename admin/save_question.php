<?php
include '../db_connect.php';

$subject  = $_POST['subject'];
$chapter  = $_POST['chapter'];
$question = $_POST['question'];
$answer   = $_POST['answer'];

$image_name = null;

// Image upload logic
if (!empty($_FILES['image']['name'])) {

    $upload_dir = "uploads/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $image_name = time() . "_" . basename($_FILES['image']['name']);
    $target_path = $upload_dir . $image_name;

    move_uploaded_file($_FILES['image']['tmp_name'], $target_path);
}

// Insert into database
$sql = "INSERT INTO practical_questions 
(subject, chapter, question, answer, image) 
VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $subject, $chapter, $question, $answer, $image_name);

if ($stmt->execute()) {
    echo "<script>alert('Question saved successfully'); window.location='add_question.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
