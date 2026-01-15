<?php
include("../db_connect.php");

if(isset($_POST['save'])){
    $name = $_POST['name'];
    $conn->query("INSERT IGNORE INTO categories (name) VALUES ('$name')");
    echo "Category Added";
}
?>

<form method="post">
    <input type="text" name="name" placeholder="LibreOffice Writer" required>
    <button name="save">Add Category</button>
</form>
