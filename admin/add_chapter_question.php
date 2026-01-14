<?php include '../db_connect.php'; ?>

<h2>Add Chapter-wise Question</h2>

<form method="post">

<label>Subject</label><br>
<select name="subject_id" required>
<?php
$s = $conn->query("SELECT * FROM subjects");
while($row=$s->fetch_assoc()){
    echo "<option value='{$row['id']}'>{$row['subject_name']}</option>";
}
?>
</select><br><br>

<label>Chapter</label><br>
<select name="chapter_id" required>
<?php
$c = $conn->query("SELECT * FROM chapters");
while($row=$c->fetch_assoc()){
    echo "<option value='{$row['id']}'>{$row['chapter_name']}</option>";
}
?>
</select><br><br>

<label>Question</label><br>
<textarea name="question" required></textarea><br><br>

<input name="a" placeholder="Option A" required><br>
<input name="b" placeholder="Option B" required><br>
<input name="c" placeholder="Option C" required><br>
<input name="d" placeholder="Option D" required><br><br>

<label>Correct Option</label>
<select name="correct">
    <option>A</option><option>B</option>
    <option>C</option><option>D</option>
</select><br><br>

<textarea name="explanation" placeholder="Explanation"></textarea><br><br>

<button name="save">Save Question</button>
</form>

<?php
if(isset($_POST['save'])){
    $conn->query("
        INSERT INTO chapter_questions
        (subject_id,chapter_id,question,option_a,option_b,option_c,option_d,correct_option,explanation)
        VALUES (
        '{$_POST['subject_id']}',
        '{$_POST['chapter_id']}',
        '{$_POST['question']}',
        '{$_POST['a']}','{$_POST['b']}','{$_POST['c']}','{$_POST['d']}',
        '{$_POST['correct']}',
        '{$_POST['explanation']}'
        )
    ");
    echo "<p style='color:green'>Question Added</p>";
}
?>
