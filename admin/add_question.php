<?php include '../db_connect.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Question</title>
</head>
<body>

<h2>Add MCQ Question</h2>

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

    <label>Test Set</label><br>
    <select name="set_id" required>
        <?php
        $q = $conn->query("SELECT * FROM test_sets");
        while($set = $q->fetch_assoc()){
            echo "<option value='{$set['id']}'>{$set['set_name']}</option>";
        }
        ?>
    </select><br><br>

    <label>Question</label><br>
    <textarea name="question" required></textarea><br><br>

    <label>Option A</label><br>
    <input type="text" name="a" required><br>

    <label>Option B</label><br>
    <input type="text" name="b" required><br>

    <label>Option C</label><br>
    <input type="text" name="c" required><br>

    <label>Option D</label><br>
    <input type="text" name="d" required><br><br>

    <label>Correct Option</label><br>
    <select name="correct">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
    </select><br><br>

    <label>Explanation</label><br>
    <textarea name="explanation"></textarea><br><br>

    <button name="save">Save Question</button>
</form>

<?php
if(isset($_POST['save'])){
    $conn->query("
        INSERT INTO questions
        (subject_id,set_id,question,option_a,option_b,option_c,option_d,correct_option,explanation)
        VALUES
        (
        '{$_POST['subject_id']}',
        '{$_POST['set_id']}',
        '{$_POST['question']}',
        '{$_POST['a']}',
        '{$_POST['b']}',
        '{$_POST['c']}',
        '{$_POST['d']}',
        '{$_POST['correct']}',
        '{$_POST['explanation']}'
        )
    ");
    echo "<p style='color:green'>Question Added Successfully</p>";
}
?>

</body>
</html>
