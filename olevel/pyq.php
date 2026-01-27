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

/* SUBJECT BUTTONS */
.subject-buttons{
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:15px;
    margin:30px 0;
}
.subject-btn{
    background:#ffffff;
    border:2px solid #1976d2;
    color:#1976d2;
    padding:12px 22px;
    border-radius:30px;
    font-size:14px;
    cursor:pointer;
    transition:.3s;
}
.subject-btn:hover,
.subject-btn.active{
    background:#1976d2;
    color:#fff;
}

/* PYQ CARDS */
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
    grid-column:1/-1;
}
</style>
</head>

<body>

<?php include 'navbar.html'; ?>

<div class="container">

<h1>Previous Year Questions (PYQ)</h1>

<!-- SUBJECT BUTTONS -->
<div class="subject-buttons">
<?php
$subjects = $conn->query("SELECT id, subject_name FROM subjects ORDER BY id ASC");
while($s = $subjects->fetch_assoc()){
    echo "<button class='subject-btn' data-id='{$s['id']}'>"
         .htmlspecialchars($s['subject_name']).
         "</button>";
}
?>
</div>

<!-- PYQ RESULT -->
<div id="pyqResult" class="pyq-grid"></div>

</div>

<script>
const buttons = document.querySelectorAll('.subject-btn');
const box = document.getElementById('pyqResult');

buttons.forEach(btn=>{
    btn.addEventListener('click', function(){

        // active button highlight
        buttons.forEach(b=>b.classList.remove('active'));
        this.classList.add('active');

        let subjectId = this.getAttribute('data-id');
        box.innerHTML = "<div class='loading'>Loading PYQs...</div>";

        fetch("fetch_pyq.php?subject_id="+subjectId)
            .then(res=>res.text())
            .then(data=>box.innerHTML=data);
    });
});
</script>

</body>
</html>
