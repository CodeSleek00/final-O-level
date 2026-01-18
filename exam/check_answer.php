<?php
include '../db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_id = intval($_POST['question_id']);
    $selected_option = $_POST['selected_option'];
    
    $query = $conn->query("SELECT correct_option FROM chapter_questions WHERE id = $question_id");
    
    if ($query->num_rows > 0) {
        $question = $query->fetch_assoc();
        $is_correct = ($selected_option === $question['correct_option']);
        
        echo json_encode([
            'success' => true,
            'is_correct' => $is_correct,
            'correct_answer' => $question['correct_option'],
            'selected_answer' => $selected_option
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Question not found']);
    }
}
?>