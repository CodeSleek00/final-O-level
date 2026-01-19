<?php 
include '../db_connect.php';
$msg = "";
$msg_type = "";

if(isset($_POST['save'])){
    $sid = $_POST['subject_id'];
    $set_name = trim($_POST['set_name']);
    
    if(empty($set_name)){
        $msg = "Please enter a set name.";
        $msg_type = "error";
    } else {
        $stmt = $conn->prepare("INSERT INTO test_sets (subject_id, set_name) VALUES (?, ?)");
        $stmt->bind_param("is", $sid, $set_name);
        
        if($stmt->execute()){
            $msg = "Test set added successfully!";
            $msg_type = "success";
            $_POST = array();
        } else {
            $msg = "Error adding test set. Please try again.";
            $msg_type = "error";
        }
    }
}

$page_title = "Add Test Set";
include "admin_header.php";
?>

<div class="admin-container">
    <div class="form-container">
        <div class="form-header">
            <h2>📝 Add Mock Test Set</h2>
            <p>Create a new mock test set for a subject</p>
        </div>

        <?php if($msg): ?>
            <div class="alert alert-<?= $msg_type === 'success' ? 'success' : 'error' ?>">
                <?= $msg_type === 'success' ? '✓' : '✗' ?> <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="subject_id">Select Subject</label>
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
                <label for="set_name">Set Name</label>
                <input type="text" id="set_name" name="set_name" 
                       placeholder="e.g., Mock Test 1, Practice Set A" 
                       value="<?= isset($_POST['set_name']) ? htmlspecialchars($_POST['set_name']) : '' ?>" 
                       required>
            </div>

            <button type="submit" name="save" class="btn btn-primary btn-full">Save Set</button>
        </form>

        <a href="admin_home.php" class="btn-back">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
