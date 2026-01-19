<?php include "db_connect.php";
$sid = $_GET['sid'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO TITLE -->
    <title>O Level Mock Test Sets | Select Test Set | NIELIT O Level Mock Test</title>
    
    <!-- META DESCRIPTION -->
    <meta name="description" content="Select O Level mock test set for practice. Choose from available test sets for M1-R5, M2-R5, M3-R5, M4-R5. Free O Level mock test preparation by Faiz Computer Institute.">
    
    <!-- KEYWORDS -->
    <meta name="keywords" content="O Level Mock Test, Test Sets, O Level Test Sets, NIELIT Mock Test, O Level Practice Test, Mock Test Sets, O Level Exam Preparation, O Level Online Test">
    
    <meta name="author" content="Faiz Computer Institute">
    <meta name="robots" content="index, follow">
    
    <!-- CANONICAL -->
    <link rel="canonical" href="https://www.faizcomputerinstitute.com/sets.php">
    
    <!-- OPEN GRAPH -->
    <meta property="og:title" content="O Level Mock Test Sets | Test Selection">
    <meta property="og:description" content="Select O Level mock test set for practice.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.faizcomputerinstitute.com/sets.php">
    <meta property="og:image" content="https://www.faizcomputerinstitute.com/image/olevel.png">
    
    <!-- TWITTER -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="O Level Mock Test Sets | NIELIT">
    <meta name="twitter:description" content="Select O Level mock test set for practice.">
    
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
