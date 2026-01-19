<?php 
include '../db_connect.php';
$msg = "";
$msg_type = "";

if(isset($_POST['save'])){
    $subject_id = $_POST['subject_id'];
    $chapter_name = trim($_POST['chapter']);
    
    if(empty($chapter_name)){
        $msg = "Please enter a chapter name.";
        $msg_type = "error";
    } else {
        $stmt = $conn->prepare("INSERT INTO chapters (subject_id, chapter_name) VALUES (?, ?)");
        $stmt->bind_param("is", $subject_id, $chapter_name);
        
        if($stmt->execute()){
            $msg = "Chapter added successfully!";
            $msg_type = "success";
            $_POST = array();
        } else {
            $msg = "Error adding chapter. Please try again.";
            $msg_type = "error";
        }
    }
}

$page_title = "Add Chapter";
include "admin_header.php";
?>

<div class="admin-container">
    <div class="form-container">
        <div class="form-header">
            <h2>📖 Add New Chapter</h2>
            <p>Create a new chapter for a subject</p>
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
                    $q = $conn->query("SELECT * FROM subjects ORDER BY subject_name");
                    while($s = $q->fetch_assoc()){
                        $selected = (isset($_POST['subject_id']) && $_POST['subject_id'] == $s['id']) ? 'selected' : '';
                        echo "<option value='{$s['id']}' $selected>{$s['subject_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="chapter">Chapter Name</label>
                <input type="text" id="chapter" name="chapter" 
                       placeholder="e.g., Introduction to HTML, CSS Basics" 
                       value="<?= isset($_POST['chapter']) ? htmlspecialchars($_POST['chapter']) : '' ?>" 
                       required>
            </div>

            <button type="submit" name="save" class="btn btn-primary btn-full">Add Chapter</button>
        </form>

        <a href="admin_home.php" class="btn-back">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
