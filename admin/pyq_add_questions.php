<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_home.php');
    exit();
}

include '../db_connect.php';
$msg = "";
$msg_type = "";

if(isset($_GET['success'])){
    $msg = "Question added successfully!";
    $msg_type = "success";
}
if(isset($_GET['error'])){
    $msg = "Error adding question. Please try again.";
    $msg_type = "error";
}

$paper_id = intval($_GET['paper_id']);

$paper = $conn->query("
    SELECT p.*, s.subject_name 
    FROM pyq_papers p
    JOIN subjects s ON p.subject_id = s.id
    WHERE p.id = $paper_id
")->fetch_assoc();

if(!$paper){
    die("Invalid Paper");
}

$page_title = "Add PYQ Questions";
include "admin_header.php";
?>

<div class="admin-container">
    <div class="form-container">
        <div class="form-header">
            <h2>📝 Add PYQ Question</h2>
            <p><?= htmlspecialchars($paper['paper_title']) ?> (<?= $paper['exam_year'] ?>)</p>
            <p style="font-size: 0.9rem; color: #6b7280; margin-top: 5px;">
                Subject: <?= htmlspecialchars($paper['subject_name']) ?>
            </p>
        </div>

        <?php if($msg): ?>
            <div class="alert alert-<?= $msg_type === 'success' ? 'success' : 'error' ?>">
                <?= $msg_type === 'success' ? '✓' : '✗' ?> <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="pyq_save_question.php">
            <input type="hidden" name="paper_id" value="<?= $paper_id ?>">

            <div class="form-group">
                <label for="question">Question</label>
                <textarea id="question" name="question" 
                          placeholder="Enter the question text here..." 
                          required></textarea>
            </div>

            <div class="options-grid">
                <div class="form-group">
                    <label for="option_a">Option A</label>
                    <input type="text" id="option_a" name="option_a" 
                           placeholder="Option A" 
                           required>
                </div>

                <div class="form-group">
                    <label for="option_b">Option B</label>
                    <input type="text" id="option_b" name="option_b" 
                           placeholder="Option B" 
                           required>
                </div>

                <div class="form-group">
                    <label for="option_c">Option C</label>
                    <input type="text" id="option_c" name="option_c" 
                           placeholder="Option C" 
                           required>
                </div>

                <div class="form-group">
                    <label for="option_d">Option D</label>
                    <input type="text" id="option_d" name="option_d" 
                           placeholder="Option D" 
                           required>
                </div>
            </div>

            <div class="form-group">
                <label for="correct_option">Correct Option</label>
                <select id="correct_option" name="correct_option" required>
                    <option value="">Select Correct Option</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>

            <div class="form-group">
                <label for="explanation">Explanation (Optional)</label>
                <textarea id="explanation" name="explanation" 
                          placeholder="Explain why this is the correct answer..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Save Question</button>
        </form>

        <a href="pyq_papers.php" class="btn-back">← Back to PYQ Papers</a>
    </div>

    <div class="section-header" style="margin-top: 50px;">
        <h2>📋 Existing Questions (<?php
            $count = $conn->query("SELECT COUNT(*) as total FROM pyq_questions WHERE paper_id=$paper_id")->fetch_assoc()['total'];
            echo $count;
        ?>)</h2>
    </div>

    <div class="form-container">
        <?php
        $q = $conn->query("
            SELECT * FROM pyq_questions WHERE paper_id=$paper_id ORDER BY id ASC
        ");
        $i=1;
        if($q && $q->num_rows > 0){
            while($row=$q->fetch_assoc()){
        ?>
            <div style="background: #f9fafb; padding: 20px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid #2563eb;">
                <p style="font-weight: 600; color: #1f2937; margin-bottom: 10px;">
                    Q<?= $i ?>. <?= htmlspecialchars($row['question']) ?>
                </p>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: 10px;">
                    <div style="padding: 8px; background: <?= $row['correct_option'] == 'A' ? '#d1fae5' : '#f3f4f6' ?>; border-radius: 6px;">
                        <strong>A:</strong> <?= htmlspecialchars($row['option_a']) ?>
                    </div>
                    <div style="padding: 8px; background: <?= $row['correct_option'] == 'B' ? '#d1fae5' : '#f3f4f6' ?>; border-radius: 6px;">
                        <strong>B:</strong> <?= htmlspecialchars($row['option_b']) ?>
                    </div>
                    <div style="padding: 8px; background: <?= $row['correct_option'] == 'C' ? '#d1fae5' : '#f3f4f6' ?>; border-radius: 6px;">
                        <strong>C:</strong> <?= htmlspecialchars($row['option_c']) ?>
                    </div>
                    <div style="padding: 8px; background: <?= $row['correct_option'] == 'D' ? '#d1fae5' : '#f3f4f6' ?>; border-radius: 6px;">
                        <strong>D:</strong> <?= htmlspecialchars($row['option_d']) ?>
                    </div>
                </div>
                <?php if(!empty($row['explanation'])): ?>
                    <p style="margin-top: 10px; padding: 10px; background: #eff6ff; border-radius: 6px; color: #1e40af;">
                        <strong>Explanation:</strong> <?= htmlspecialchars($row['explanation']) ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php 
                $i++;
            }
        } else {
            echo "<p style='color:#6b7280; text-align:center; padding:20px;'>No questions added yet. Add your first question above.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
