<!DOCTYPE html>
<html>
<head>
    <title>Add Question</title>
    <style>
        body { font-family: Arial; background:#111; color:#fff; }
        form { width:500px; margin:50px auto; }
        select, textarea, button {
            width:100%; margin:10px 0; padding:10px;
        }
    </style>
</head>
<body>

<form action="save_question.php" method="POST">
    <h2>Add Question</h2>

    <select name="subject" required>
        <option value="">Select Subject</option>
        <option>HTML</option>
        <option>CSS</option>
        <option>JavaScript</option>
        <option>LibreOffice Calc</option>
        <option>LibreOffice Impress</option>
        <option>LibreOffice Writer</option>
        <option>Python</option>
        <option>IOT</option>
    </select>

    <textarea name="question" placeholder="Write Question" required></textarea>
    <textarea name="answer" placeholder="Write Answer"></textarea>

    <button type="submit">Save</button>
</form>

</body>
</html>
