<?php
include("../db_connect.php");
$msg = "";
$msg_type = "";

$cats = $conn->query("SELECT * FROM categories ORDER BY name");

if(isset($_POST['save'])){
    $cat = trim($_POST['category']);
    $key = trim($_POST['shortcut_key']);
    $desc = trim($_POST['description']);
    
    if(empty($cat) || empty($key) || empty($desc)){
        $msg = "Please fill in all fields.";
        $msg_type = "error";
    } else {
        $stmt = $conn->prepare("INSERT INTO shortcuts (category, shortcut_key, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $cat, $key, $desc);
        
        if($stmt->execute()){
            $msg = "Shortcut added successfully!";
            $msg_type = "success";
            $_POST = array();
        } else {
            $msg = "Error adding shortcut. Please try again.";
            $msg_type = "error";
        }
    }
}

$page_title = "Add Shortcut";
include "admin_header.php";
?>

<div class="admin-container">
    <div class="form-container">
        <div class="form-header">
            <h2>⌨️ Add Keyboard Shortcut</h2>
            <p>Add a new keyboard shortcut to a category</p>
        </div>

        <?php if($msg): ?>
            <div class="alert alert-<?= $msg_type === 'success' ? 'success' : 'error' ?>">
                <?= $msg_type === 'success' ? '✓' : '✗' ?> <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="">Select Category</option>
                    <?php 
                    while($c = $cats->fetch_assoc()) { 
                        $selected = (isset($_POST['category']) && $_POST['category'] == $c['name']) ? 'selected' : '';
                        echo "<option value='".htmlspecialchars($c['name'])."' $selected>".htmlspecialchars($c['name'])."</option>";
                    } 
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="shortcut_key">Shortcut Key</label>
                <input type="text" id="shortcut_key" name="shortcut_key" 
                       placeholder="e.g., Ctrl + C, Alt + F4, Ctrl + Shift + S" 
                       value="<?= isset($_POST['shortcut_key']) ? htmlspecialchars($_POST['shortcut_key']) : '' ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" id="description" name="description" 
                       placeholder="e.g., Copy, Close Window, Save As" 
                       value="<?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?>" 
                       required>
            </div>

            <button type="submit" name="save" class="btn btn-primary btn-full">Save Shortcut</button>
        </form>

        <a href="admin_home.php" class="btn-back">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
