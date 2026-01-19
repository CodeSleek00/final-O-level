<?php
include("../db_connect.php");

$q = $conn->query("SELECT * FROM practical_questions WHERE subject='LibreOffice Writer' ORDER BY chapter, id");
$questions = [];

while($row = $q->fetch_assoc()){
    $questions[$row['chapter']][] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>LibreOffice Writer Practical Questions - All</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Poppins', Arial;
    background:#f4f6f9;
   
}
.chapter{
    background:#fff;
    padding:15px;
    margin-bottom:20px;
    border-radius:6px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
    margin: 20px;
}
.chapter h2{
    margin:0 0 10px;
    color:#2c3e50;
}
ol{
    padding-left:20px;
}
li{
    margin:6px 0;
}
a{
    text-decoration:none;
    color:#0066cc;
}
a:hover{
    
    transition: all 0.3s ease-in-out;
    color: mediumseagreen;
}

        /* ===== BANNER ===== */
        .it-banner {
            background: url('../image/bg.svg');
            background-size: cover;
            background-position: center center;
            padding: 40px 40px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            text-align: center;
            margin-bottom: 50px;
            background-color: black;
            color: white;
            margin: 10px;
        }

</style>
</head>
<body>

<?php include 'navbar.html'; ?>
 <!-- ================= BANNER ================= -->
    <section class="it-banner">
        <h1>LibreOffice Writer Practicals</h1>
        <p>
            Practice updated MCQs based on the latest NIELIT syllabus.
            Improve accuracy, speed, and confidence with topic-wise
            LibreOffice Writer practcial designed for O Level students.
        </p>
    </section>

<?php foreach($questions as $chapter => $rows){ ?>
<div class="chapter">
    <h2><?php echo htmlspecialchars($chapter); ?> Practical</h2>
    <ol>
        <?php foreach($rows as $q){ ?>
        <li>
            <a href="view.php?id=<?php echo $q['id']; ?>">
                <?php echo htmlspecialchars($q['question']); ?>
            </a>
        </li>
        <?php } ?>
    </ol>
</div>
<?php } ?>

</body>
</html>
