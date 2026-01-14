<?php include '../db_connect.php'; ?>

<h2>Add Chapter</h2>

<form method="post">
    <label>Subject</label><br>
    <select name="subject_id" required>
        <?php
        $q = $conn->query("SELECT * FROM subjects");
        while($s = $q->fetch_assoc()){
            echo "<option value='{$s['id']}'>{$s['subject_name']}</option>";
        }
        ?>
    </select><br><br>

    <label>Chapter Name</label><br>
    <input type="text" name="chapter" required><br><br>

    <button name="save">Add Chapter</button>
</form>

<?php
if(isset($_POST['save'])){
    $conn->query("
        INSERT INTO chapters (subject_id, chapter_name)
        VALUES ('{$_POST['subject_id']}', '{$_POST['chapter']}')
    ");
    echo "<p style='color:green'>Chapter Added</p>";
}
?>
