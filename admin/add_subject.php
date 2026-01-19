<?php
include "../db_connect.php";
$msg = "";
$msg_type = "";

// ===== FORM SUBMISSION =====
if(isset($_POST['submit'])){
    $subject_name = trim($_POST['subject_name']);
    
    if(empty($subject_name)){
        $msg = "Please enter a subject name.";
        $msg_type = "error";
    } else {
        // Check if subject already exists
        $stmt = $conn->prepare("SELECT id FROM subjects WHERE subject_name=?");
        $stmt->bind_param("s", $subject_name);
        $stmt->execute();
        $check = $stmt->get_result();
        
        if($check->num_rows > 0){
            $msg = "Subject already exists!";
            $msg_type = "error";
        } else {
            // Insert subject
            $stmt = $conn->prepare("INSERT INTO subjects(subject_name) VALUES(?)");
            $stmt->bind_param("s", $subject_name);
            if($stmt->execute()){
                $msg = "Subject added successfully!";
                $msg_type = "success";
                $_POST = array(); // Clear form
            } else {
                $msg = "Error adding subject. Please try again.";
                $msg_type = "error";
            }
        }
    }
}

$page_title = "Add Subject";
include "admin_header.php";
?>

<div class="admin-container">
    <div class="form-container">
        <div class="form-header">
            <h2>📚 Add New Subject</h2>
            <p>Create a new subject for the O-Level exam system</p>
        </div>

        <?php if($msg): ?>
            <div class="alert alert-<?= $msg_type === 'success' ? 'success' : 'error' ?>">
                <?= $msg_type === 'success' ? '✓' : '✗' ?> <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="subject_name">Subject Name</label>
                <input type="text" id="subject_name" name="subject_name" 
                       placeholder="e.g., M1-R5, M2-R5, M3-R5" 
                       value="<?= isset($_POST['subject_name']) ? htmlspecialchars($_POST['subject_name']) : '' ?>" 
                       required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary btn-full">Add Subject</button>
        </form>

        <a href="admin_home.php" class="btn-back">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
