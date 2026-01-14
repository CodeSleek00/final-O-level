<?php
include '../db_connect.php';
$subject_id = 1; // IT Tools (M1-R5)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M1-R5 (IT Tools)</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

</head>


<body>
    <!-- Navbar would be included here -->
        <?php include '../navbar.html'; ?>
    
    
    <style>
        body{
            font-family: 'Poppins', sans-serif;
            background:#f4f6f9;
            margin:0;
        }
        .container{
            max-width:900px;
            margin:80px auto;
            padding:20px;
        }
        .module-title{
            text-align:center;
            margin-bottom:30px;
        }
        .set-box{
            background:#fff;
            padding:20px;
            border-radius:12px;
            box-shadow:0 10px 25px rgba(0,0,0,.08);
        }
        .set-box a{
            display:block;
            padding:15px;
            margin-bottom:15px;
            background:#0d6efd;
            color:#fff;
            text-decoration:none;
            border-radius:8px;
            font-weight:500;
            transition:.3s;
        }
        .set-box a:hover{
            background:#084298;
        }
    </style>
</head>

<body>

<?php include '../navbar.html'; ?>

<div class="container">
    <div class="module-title">
        <h2>M1-R5 – IT Tools</h2>
        <p>Select Test Set</p>
    </div>

    <div class="set-box">
        <?php
        $q = $conn->query("SELECT * FROM test_sets WHERE subject_id=$subject_id");
        while($row = $q->fetch_assoc()){
            echo "<a href='../exam.php?sid=$subject_id&setid={$row['id']}'>
                    <i class='fa-solid fa-file-lines'></i> {$row['set_name']}
                  </a>";
        }
        ?>
    </div>
</div>

</body>
</html>
