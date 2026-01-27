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
    $msg = "Paper added successfully!";
    $msg_type = "success";
}
if(isset($_GET['error'])){
    $msg = "Error adding paper. Please try again.";
    $msg_type = "error";
}

/* FETCH SUBJECTS */
$subjects = $conn->query("SELECT id, subject_name FROM subjects ORDER BY id ASC");

$page_title = "Add PYQ Paper";
include "admin_header.php";
?>

<div class="admin-container">
    <div class="form-container">
        <div class="form-header">
            <h2>📋 Add Previous Year Question Paper</h2>
            <p>Create a new PYQ paper for a subject</p>
        </div>

        <?php if($msg): ?>
            <div class="alert alert-<?= $msg_type === 'success' ? 'success' : 'error' ?>">
                <?= $msg_type === 'success' ? '✓' : '✗' ?> <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="pyq_save_paper.php">
            <div class="form-group">
                <label for="subject_id">Subject</label>
                <select id="subject_id" name="subject_id" required>
                    <option value="">Select a Subject</option>
                    <?php while($s=$subjects->fetch_assoc()){ ?>
                        <option value="<?= $s['id'] ?>">
                            <?= htmlspecialchars($s['subject_name']) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="paper_title">Paper Title</label>
                <input type="text" id="paper_title" name="paper_title" 
                       placeholder="e.g., IT Tools PYQ, M1-R5 Previous Year Questions" 
                       required>
            </div>

            <div class="form-group">
                <label for="exam_year">Exam Year</label>
                <input type="number" id="exam_year" name="exam_year" 
                       placeholder="e.g., 2023, 2024" 
                       min="2000" max="2099" 
                       required>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Add Paper</button>
        </form>

        <a href="admin_home.php" class="btn-back">← Back to Dashboard</a>
    </div>

    <div class="section-header" style="margin-top: 50px;">
        <h2>📚 Existing PYQ Papers</h2>
    </div>

    <div class="action-grid">
        <?php
        $papers = $conn->query("
            SELECT p.*, s.subject_name,
                   (SELECT COUNT(*) FROM pyq_questions WHERE paper_id = p.id) as question_count
            FROM pyq_papers p
            JOIN subjects s ON p.subject_id = s.id
            ORDER BY p.exam_year DESC
       ");

        if($papers && $papers->num_rows > 0){
            while($p=$papers->fetch_assoc()){
        ?>
            <a href="pyq_add_questions.php?paper_id=<?= $p['id'] ?>" class="action-btn">
                <div class="action-btn-icon">📄</div>
                <div class="action-btn-content">
                    <h3><?= htmlspecialchars($p['paper_title']) ?></h3>
                    <p><?= htmlspecialchars($p['subject_name']) ?> • Year: <?= $p['exam_year'] ?> • Questions: <?= $p['question_count'] ?></p>
                </div>
            </a>
        <?php 
            }
        } else {
            echo "<p style='color:#6b7280; text-align:center; padding:20px;'>No PYQ papers found. Create your first paper above.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
