<?php
include '../db_connect.php';

$subject  = trim($_POST['subject']);
$chapter  = trim($_POST['chapter']);
$question = trim($_POST['question']);
$answer   = trim($_POST['answer']);

$image_name = null;

// Image upload logic
if (!empty($_FILES['image']['name'])) {
    $upload_dir = "uploads/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    $file_type = $_FILES['image']['type'];
    
    if (in_array($file_type, $allowed_types)) {
        $image_name = time() . "_" . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $image_name;
        
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            echo "<script>alert('Error uploading image'); window.location='add_practical_question.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Invalid image format. Please use JPG, PNG, or GIF.'); window.location='add_practical_question.php';</script>";
        exit;
    }
}

// Insert into database
$sql = "INSERT INTO practical_questions 
(subject, chapter, question, answer, image) 
VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $subject, $chapter, $question, $answer, $image_name);

if ($stmt->execute()) {
    echo "<script>alert('Question saved successfully!'); window.location='add_practical_question.php';</script>";
} else {
    echo "<script>alert('Error: " . addslashes($conn->error) . "'); window.location='add_practical_question.php';</script>";
}
?>
