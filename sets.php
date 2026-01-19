<?php include "db_connect.php";
$sid = $_GET['sid'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Test Set</title>
    <link rel="icon" type="image/png" href="image/olevel.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding: 40px;
            background: #f8f9fa;
        }
        h2 {
            color: #2563eb;
            margin-bottom: 20px;
        }
        a {
            display: inline-block;
            padding: 12px 24px;
            margin: 8px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s;
        }
        a:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <h2>Select Test Set</h2>
    <?php
    $q = $conn->query("SELECT * FROM test_sets WHERE subject_id=$sid");
    while($set = $q->fetch_assoc()){
        echo "<a href='exam.php?sid=$sid&setid={$set['id']}'>{$set['set_name']}</a>";
    }
    ?>
</body>
</html>
