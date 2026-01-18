<?php
include("../db_connect.php");

$q = $conn->query("SELECT * FROM practical_questions WHERE subject='HTML' ORDER BY chapter, id");
$questions = [];

while($row = $q->fetch_assoc()){
    $questions[$row['chapter']][] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>HTML Practical Questions - All</title>
<style>
body{
    font-family:Segoe UI, Arial;
    background:#f4f6f9;
    padding:20px;
}
.chapter{
    background:#fff;
    padding:15px;
    margin-bottom:20px;
    border-radius:6px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}
.chapter h2{
    margin:0 0 10px;
    color:#2c3e50;
}
ul{
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
    text-decoration:underline;
}
</style>
</head>
<body>

<h1> CSS Practical Questions</h1>

<?php foreach($questions as $chapter => $rows){ ?>
<div class="chapter">
    <h2>Chapter - <?php echo htmlspecialchars($chapter); ?></h2>
    <ul>
        <?php foreach($rows as $q){ ?>
        <li>
            <a href="view.php?id=<?php echo $q['id']; ?>">
                <?php echo htmlspecialchars($q['question']); ?>
            </a>
        </li>
        <?php } ?>
    </ul>
</div>
<?php } ?>

</body>
</html>
