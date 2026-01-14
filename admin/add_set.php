<?php include '../db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Test Set</title>
</head>
<body>

<h2>Add Test Set</h2>

<form method="post">
    <label>Select Subject</label><br>
    <select name="subject_id" required>
        <?php
        $q = $conn->query("SELECT * FROM subjects");
        while($s = $q->fetch_assoc()){
            echo "<option value='{$s['id']}'>{$s['subject_name']}</option>";
        }
        ?>
    </select><br><br>

    <label>Set Name</label><br>
    <input type="text" name="set_name" required><br><br>

    <button name="save">Save Set</button>
</form>

<?php
if(isset($_POST['save'])){
    $sid = $_POST['subject_id'];
    $set = $_POST['set_name'];

    $conn->query("INSERT INTO test_sets (subject_id,set_name) VALUES ('$sid','$set')");
    echo "<p style='color:green'>Set Added Successfully</p>";
}
?>

</body>
</html>
