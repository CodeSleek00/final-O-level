<?php include '../db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Previous Year Questions | O Level</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:Poppins;
    background:#f5f9ff;
    margin:0;
}
.container{
    max-width:1100px;
    margin:40px auto;
    padding:20px;
}
h1{
    text-align:center;
    color:#0d47a1;
    font-weight:500;
}
.select-box{
    max-width:400px;
    margin:30px auto;
}
select{
    width:100%;
    padding:12px;
    font-size:15px;
    border-radius:8px;
    border:1px solid #cfd8dc;
}
.pyq-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    margin-top:30px;
}
.card{
    background:#fff;
    padding:20px;
    border-radius:16px;
    box-shadow:0 8px 20px rgba(0,0,0,0.06);
    transition:.3s;
}
.card:hover{
    transform:translateY(-6px);
}
.card h3{
    margin:0;
    color:#0d47a1;
    font-weight:500;
}
.card p{
    font-size:14px;
    color:#555;
}
.start-btn{
    display:inline-block;
    margin-top:10px;
    background:#1976d2;
    color:#fff;
    padding:8px 18px;
    border-radius:20px;
    text-decoration:none;
    font-size:14px;
}
.loading{
    text-align:center;
    color:#555;
}
</style>
</head>

<body>

<?php include 'navbar.html'; ?>

<div class="container">

<h1>Previous Year Questions (PYQ)</h1>

<div class="select-box">
    <select id="subject">
        <option value="">Select Subject</option>
        <?php
        $subjects = $conn->query("SELECT id, subject_name FROM subjects ORDER BY id ASC");
        while($s=$subjects->fetch_assoc()){
            echo "<option value='{$s['id']}'>".htmlspecialchars($s['subject_name'])."</option>";
        }
        ?>
    </select>
</div>

<div id="pyqResult" class="pyq-grid"></div>

</div>

<script>
document.getElementById('subject').addEventListener('change', function(){
    let subjectId = this.value;
    let box = document.getElementById('pyqResult');

    if(subjectId===""){
        box.innerHTML = "";
        return;
    }

    box.innerHTML = "<div class='loading'>Loading PYQs...</div>";

    fetch("fetch_pyq.php?subject_id="+subjectId)
        .then(res=>res.text())
        .then(data=>box.innerHTML=data);
});
</script>

</body>
</html>
