<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_home.php');
    exit();
}

include '../db_connect.php';
$msg = "";
$msg_type = "";

if(isset($_POST['save'])){
    $subject_id = $_POST['subject_id'];
    $chapter_id = $_POST['chapter_id'];
    $question = trim($_POST['question']);
    $option_a = trim($_POST['a']);
    $option_b = trim($_POST['b']);
    $option_c = trim($_POST['c']);
    $option_d = trim($_POST['d']);
    $correct = $_POST['correct'];
    $explanation = trim($_POST['explanation']);
    
    if(empty($question) || empty($option_a) || empty($option_b) || empty($option_c) || empty($option_d)){
        $msg = "Please fill in all required fields.";
        $msg_type = "error";
    } else {
        $stmt = $conn->prepare("INSERT INTO chapter_questions (subject_id, chapter_id, question, option_a, option_b, option_c, option_d, correct_option, explanation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssssss", $subject_id, $chapter_id, $question, $option_a, $option_b, $option_c, $option_d, $correct, $explanation);
        
        if($stmt->execute()){
            $msg = "Chapter question added successfully!";
            $msg_type = "success";
            $_POST = array();
        } else {
            $msg = "Error adding question. Please try again.";
            $msg_type = "error";
        }
    }
}

$page_title = "Add Chapter Question";
include "admin_header.php";
?>

<div class="admin-container">
    <div class="form-container">
        <div class="form-header">
            <h2>📘 Add Chapter-wise Question</h2>
            <p>Create a new question for a specific chapter</p>
        </div>

        <?php if($msg): ?>
            <div class="alert alert-<?= $msg_type === 'success' ? 'success' : 'error' ?>">
                <?= $msg_type === 'success' ? '✓' : '✗' ?> <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="subject_id">Subject</label>
                <select id="subject_id" name="subject_id" required>
                    <option value="">Select a Subject</option>
                    <?php
                    $s = $conn->query("SELECT * FROM subjects ORDER BY subject_name");
                    while($row = $s->fetch_assoc()){
                        $selected = (isset($_POST['subject_id']) && $_POST['subject_id'] == $row['id']) ? 'selected' : '';
                        echo "<option value='{$row['id']}' $selected>{$row['subject_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="chapter_id">Chapter</label>
                <select id="chapter_id" name="chapter_id" required>
                    <option value="">Select a Chapter</option>
                    <?php
                    $c = $conn->query("SELECT * FROM chapters ORDER BY chapter_name");
                    while($row = $c->fetch_assoc()){
                        $selected = (isset($_POST['chapter_id']) && $_POST['chapter_id'] == $row['id']) ? 'selected' : '';
                        echo "<option value='{$row['id']}' $selected>{$row['chapter_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="question">Question</label>
                <textarea id="question" name="question" required placeholder="Enter the question text here..."><?= isset($_POST['question']) ? htmlspecialchars($_POST['question']) : '' ?></textarea>
            </div>

            <div class="options-grid">
                <div class="form-group">
                    <label for="a">Option A</label>
                    <input type="text" id="a" name="a" 
                           value="<?= isset($_POST['a']) ? htmlspecialchars($_POST['a']) : '' ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="b">Option B</label>
                    <input type="text" id="b" name="b" 
                           value="<?= isset($_POST['b']) ? htmlspecialchars($_POST['b']) : '' ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="c">Option C</label>
                    <input type="text" id="c" name="c" 
                           value="<?= isset($_POST['c']) ? htmlspecialchars($_POST['c']) : '' ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="d">Option D</label>
                    <input type="text" id="d" name="d" 
                           value="<?= isset($_POST['d']) ? htmlspecialchars($_POST['d']) : '' ?>" 
                           required>
                </div>
            </div>

            <div class="form-group">
                <label for="correct">Correct Option</label>
                <select id="correct" name="correct" required>
                    <option value="A" <?= (isset($_POST['correct']) && $_POST['correct'] == 'A') ? 'selected' : '' ?>>A</option>
                    <option value="B" <?= (isset($_POST['correct']) && $_POST['correct'] == 'B') ? 'selected' : '' ?>>B</option>
                    <option value="C" <?= (isset($_POST['correct']) && $_POST['correct'] == 'C') ? 'selected' : '' ?>>C</option>
                    <option value="D" <?= (isset($_POST['correct']) && $_POST['correct'] == 'D') ? 'selected' : '' ?>>D</option>
                </select>
            </div>

            <div class="form-group">
                <label for="explanation">Explanation (Optional)</label>
                <textarea id="explanation" name="explanation" placeholder="Explain why this is the correct answer..."><?= isset($_POST['explanation']) ? htmlspecialchars($_POST['explanation']) : '' ?></textarea>
            </div>

            <button type="submit" name="save" class="btn btn-primary btn-full">Save Question</button>
        </form>

        <a href="admin_home.php" class="btn-back">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
