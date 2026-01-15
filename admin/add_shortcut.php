<?php
include("../db_connect.php");
$cats = $conn->query("SELECT * FROM categories");

if(isset($_POST['save'])){
    $cat = $_POST['category'];
    $key = $_POST['shortcut_key'];
    $desc = $_POST['description'];

    $conn->query("INSERT INTO shortcuts (category, shortcut_key, description)
                  VALUES ('$cat','$key','$desc')");
    echo "Shortcut Added";
}
?>

<form method="post">
    <select name="category" required>
        <option value="">Select Category</option>
        <?php while($c = $cats->fetch_assoc()) { ?>
            <option value="<?= $c['name'] ?>"><?= $c['name'] ?></option>
        <?php } ?>
    </select>

    <input type="text" name="shortcut_key" placeholder="Ctrl + C" required>
    <input type="text" name="description" placeholder="Copy" required>

    <button name="save">Save Shortcut</button>
</form>
