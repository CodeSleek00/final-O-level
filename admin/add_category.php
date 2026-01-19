<?php
include("../db_connect.php");
$msg = "";
$msg_type = "";

if(isset($_POST['save'])){
    $name = trim($_POST['name']);
    
    if(empty($name)){
        $msg = "Please enter a category name.";
        $msg_type = "error";
    } else {
        $stmt = $conn->prepare("INSERT IGNORE INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        
        if($stmt->execute()){
            if($stmt->affected_rows > 0){
                $msg = "Category added successfully!";
                $msg_type = "success";
                $_POST = array();
            } else {
                $msg = "Category already exists!";
                $msg_type = "warning";
            }
        } else {
            $msg = "Error adding category. Please try again.";
            $msg_type = "error";
        }
    }
}

$page_title = "Add Category";
include "admin_header.php";
?>

<div class="admin-container">
    <div class="form-container">
        <div class="form-header">
            <h2>🏷️ Add Shortcut Category</h2>
            <p>Create a new category for keyboard shortcuts</p>
        </div>

        <?php if($msg): ?>
            <div class="alert alert-<?= $msg_type === 'success' ? 'success' : ($msg_type === 'warning' ? 'warning' : 'error') ?>">
                <?= $msg_type === 'success' ? '✓' : ($msg_type === 'warning' ? '⚠' : '✗') ?> <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" id="name" name="name" 
                       placeholder="e.g., LibreOffice Writer, LibreOffice Calc" 
                       value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" 
                       required>
            </div>

            <button type="submit" name="save" class="btn btn-primary btn-full">Add Category</button>
        </form>

        <a href="admin_home.php" class="btn-back">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
