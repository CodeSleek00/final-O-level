<?php
include '../db_connect.php';

// Get chapter ID from URL
$cid = isset($_GET['chapter_id']) ? intval($_GET['chapter_id']) : 0;
if(!$cid){
    die("<p style='text-align:center; margin-top:50px; font-size:18px; color:red;'>Invalid Chapter ID. <a href='chapter_list.php'>Go Back</a></p>");
}

/* ===== FETCH CHAPTER INFO ===== */
$chapter_query = $conn->query("
    SELECT c.chapter_name, s.subject_name
    FROM chapters c
    JOIN subjects s ON c.subject_id = s.id
    WHERE c.id = $cid
");

if($chapter_query->num_rows == 0){
    die("<p style='text-align:center; margin-top:50px; font-size:18px; color:red;'>Chapter not found. <a href='chapter_list.php'>Go Back</a></p>");
}

$chapter = $chapter_query->fetch_assoc();

/* ===== FETCH QUESTIONS ===== */
$questions = $conn->query("
    SELECT * FROM chapter_questions
    WHERE chapter_id = $cid
");

if($questions->num_rows == 0){
    die("<p style='text-align:center; margin-top:50px; font-size:18px; color:red;'>No questions found for this chapter. <a href='chapter_list.php'>Go Back</a></p>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($chapter['chapter_name']); ?> | Chapter Practice</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family:'Poppins',sans-serif;
    background:#f4f6f9;
    margin:0;
}
.container {
    max-width:900px;
    margin:50px auto 80px auto;
    padding:20px;
    background:#fff;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}
h2 { margin-bottom:5px; }
.subtitle {
    color:#666;
    font-size:14px;
    margin-bottom:30px;
}
.question { margin-bottom:25px; }
.question p { font-weight:500; }
.options label {
    display:block;
    padding:10px 14px;
    border:1px solid #ddd;
    border-radius:8px;
    margin-bottom:10px;
    cursor:pointer;
}
.submit-btn {
    background:#0d6efd;
    color:#fff;
    border:none;
    padding:14px 30px;
    border-radius:30px;
    font-size:16px;
    cursor:pointer;
}
.correct { background:#d4edda; border-color:#28a745; }
.wrong { background:#f8d7da; border-color:#dc3545; }
.explain { font-size:14px; color:#333; margin-top:8px; }
.back-link { display:inline-block; margin-top:20px; color:#0d6efd; text-decoration:none; }
.back-link:hover { text-decoration:underline; }
</style>
</head>

<body>

<div class="container">

<h2><?= htmlspecialchars($chapter['chapter_name']); ?></h2>
<div class="subtitle"><?= htmlspecialchars($chapter['subject_name']); ?> • Chapter-wise Practice</div>

<form method="post">

<?php $i=1; while($q = $questions->fetch_assoc()){ ?>
<div class="question">
    <p>Q<?= $i++; ?>. <?= htmlspecialchars($q['question']); ?></p>

    <div class="options">
        <?php foreach(['A','B','C','D'] as $opt):
            $text = $q['option_'.strtolower($opt)];
        ?>
        <label>
            <input type="radio" name="ans[<?= $q['id']; ?>]" value="<?= $opt; ?>">
            <?= htmlspecialchars($text); ?>
        </label>
        <?php endforeach; ?>
    </div>

    <?php
    if(isset($_POST['submit'])){
        $user = $_POST['ans'][$q['id']] ?? '';
        $correct = $q['correct_option'];

        if($user){
            echo $user == $correct
                ? "<div class='explain correct'>✅ Correct</div>"
                : "<div class='explain wrong'>❌ Wrong | Correct: $correct</div>";
        }
        if(!empty($q['explanation'])){
            echo "<div class='explain'><b>Explanation:</b> ".htmlspecialchars($q['explanation'])."</div>";
        }
    }
    ?>
</div>
<?php } ?>

<button class="submit-btn" name="submit">Submit Practice</button>
</form>

<a class="back-link" href="chapter_list.php">← Back to Chapters</a>

</div>

</body>
</html>
