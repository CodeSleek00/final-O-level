<?php
include "../db_connect.php";
$msg = "";

// ===== FORM SUBMISSION =====
if(isset($_POST['submit'])){
    $subject_name = trim($_POST['subject_name']);
    
    if(empty($subject_name)){
        $msg = "Please enter a subject name.";
    } else {
        // Check if subject already exists
        $check = $conn->query("SELECT id FROM subjects WHERE subject_name='$subject_name'");
        if($check->num_rows > 0){
            $msg = "Subject already exists!";
        } else {
            // Insert subject
            $conn->query("INSERT INTO subjects(subject_name) VALUES('$subject_name')");
            $msg = "Subject added successfully!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Add Subject</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body{font-family:Poppins;background:#f4f6f9;margin:0;padding:30px}
.box{max-width:400px;margin:80px auto;background:#fff;padding:30px;border-radius:12px;box-shadow:0 5px 15px rgba(0,0,0,.1)}
h2{text-align:center;margin-bottom:20px}
input[type=text]{width:100%;padding:12px;margin-bottom:15px;border-radius:8px;border:1px solid #ccc;font-size:16px}
input[type=submit]{width:100%;padding:12px;background:#0d6efd;color:#fff;border:none;border-radius:8px;font-size:16px;cursor:pointer}
.msg{text-align:center;margin-bottom:15px;color:red;font-weight:600}
a.back{display:block;text-align:center;margin-top:15px;color:#0d6efd;text-decoration:none}
</style>
</head>
<body>

<div class="box">
    <h2>➕ Add New Subject</h2>

    <?php if($msg){ echo "<div class='msg'>$msg</div>"; } ?>

    <form method="post" action="">
        <input type="text" name="subject_name" placeholder="Enter Subject Name" required>
        <input type="submit" name="submit" value="Add Subject">
    </form>

    <a class="back" href="admin_dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
