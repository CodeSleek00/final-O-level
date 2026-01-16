<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Practical Question</title>

    <style>
        *{
            box-sizing:border-box;
            font-family:Segoe UI, Arial, sans-serif;
        }

        body{
            background:#f4f6f9;
            margin:0;
            padding:0;
        }

        .form-box{
            width:520px;
            margin:50px auto;
            background:#fff;
            padding:25px;
            border-radius:10px;
            box-shadow:0 10px 25px rgba(0,0,0,0.1);
        }

        h2{
            margin-bottom:15px;
            text-align:center;
            color:#333;
        }

        label{
            font-size:14px;
            color:#444;
            margin-top:10px;
            display:block;
        }

        select, textarea, input{
            width:100%;
            margin-top:6px;
            padding:10px;
            border:1px solid #ccc;
            border-radius:6px;
            font-size:14px;
        }

        textarea{
            resize:vertical;
            min-height:90px;
            font-family:monospace;
        }

        button{
            margin-top:15px;
            width:100%;
            padding:12px;
            background:#007bff;
            border:none;
            color:#fff;
            font-size:15px;
            border-radius:6px;
            cursor:pointer;
        }

        button:hover{
            background:#0056b3;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Add Practical Question</h2>

    <form action="save_question.php" method="POST">

        <label>Subject</label>
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

        <label>Chapter</label>
        <input type="text" name="chapter" placeholder="e.g. Forms, Tables, Flexbox" required>

        <label>Question</label>
        <textarea name="question" placeholder="Write practical question here..." required></textarea>

        <label>Answer (Code)</label>
        <textarea name="answer" placeholder="Write full HTML / CSS / JS code here..."></textarea>

        <button type="submit">Save Question</button>
    </form>
</div>

</body>
</html>
