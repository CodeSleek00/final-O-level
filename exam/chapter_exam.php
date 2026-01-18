<?php
include '../db_connect.php';

/* ===== GET CHAPTER ID ===== */
$cid = isset($_GET['chapter_id']) ? intval($_GET['chapter_id']) : 0;
if(!$cid){
    die("Invalid Chapter ID");
}

/* ===== PAGINATION ===== */
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

/* ===== CHAPTER INFO ===== */
$chapter_q = $conn->query("
    SELECT c.chapter_name, s.subject_name
    FROM chapters c
    JOIN subjects s ON c.subject_id = s.id
    WHERE c.id = $cid
");
if($chapter_q->num_rows == 0){
    die("Chapter not found");
}
$chapter = $chapter_q->fetch_assoc();

/* ===== TOTAL QUESTIONS ===== */
$total_q = $conn->query("
    SELECT COUNT(*) as total 
    FROM chapter_questions 
    WHERE chapter_id = $cid
");
$total = $total_q->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

/* ===== FETCH QUESTIONS ===== */
$questions = $conn->query("
    SELECT * FROM chapter_questions
    WHERE chapter_id = $cid
    LIMIT $limit OFFSET $offset
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($chapter['chapter_name']); ?> | Practice</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background:#f4f6f9;
}

/* ===== SIDE BANNERS ===== */
.side-banner{
    position:fixed;
    top:90px;
    width:230px;
    height:720px;
    background:#e5efff;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:12px;
    overflow:hidden;
}
.side-banner img{
    width:100%;
    height:100%;
    object-fit:cover;
}
.left-banner{ left:15px; }
.right-banner{ right:15px; }

/* ===== BACK ICON ===== */
.back-icon{
    position:fixed;
    top:20px;
    left:20px;
    width:42px;
    height:42px;
    border-radius:50%;
    background:#0d6efd;
    color:#fff;
    font-size:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    box-shadow:0 4px 15px rgba(13,110,253,.4);
}

/* ===== MAIN CONTAINER ===== */
.container{
    max-width:900px;
    margin:40px auto 80px;
    background:#fff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    border-top:6px solid #0d6efd;
}

h2{
    margin:0;
    color:#0d6efd;
}

.subtitle{
    font-size:14px;
    color:#64748b;
    margin-bottom:30px;
}

.question{
    margin-bottom:30px;
}

.question p{
    font-weight:500;
}

.options label{
    display:block;
    padding:10px 14px;
    border:1px solid #e5e7eb;
    border-radius:8px;
    margin-bottom:10px;
    cursor:pointer;
    transition:.2s;
}
.options label:hover{
    background:#eaf2ff;
    border-color:#0d6efd;
}

.result{
    margin-top:8px;
    font-size:14px;
}

.correct{
    background:#e7f1ff;
    border:1px solid #0d6efd;
    color:#0a3fa8;
    padding:8px;
    border-radius:6px;
}
.wrong{
    background:#fef2f2;
    border:1px solid #ef4444;
    color:#7f1d1d;
    padding:8px;
    border-radius:6px;
}

.explain-toggle{
    font-size:13px;
    color:#0d6efd;
    text-align:right;
    cursor:pointer;
    margin-top:6px;
}

.explanation{
    display:none;
    margin-top:10px;
    background:#f8fafc;
    padding:12px;
    border-radius:10px;
    font-size:14px;
}

/* ===== PAGINATION ===== */
.pagination{
    display:flex;
    justify-content:space-between;
    margin-top:40px;
}
.page-btn{
    padding:10px 22px;
    border-radius:30px;
    background:#0d6efd;
    color:#fff;
    text-decoration:none;
    font-size:14px;
}
.page-btn.disabled{
    opacity:.4;
    pointer-events:none;
}

.back{
    display:inline-block;
    margin-top:30px;
    color:#0d6efd;
    text-decoration:none;
    font-size:14px;
}

/* ===== MOBILE VIEW ===== */
@media(max-width:1024px){
    .side-banner{ display:none; }
    .back-icon{ left:10px; }
}
</style>
</head>

<body>

<!-- BACK ICON -->
<div class="back-icon" onclick="history.back()">←</div>

<!-- LEFT BANNER -->
<div class="side-banner left-banner">
    <img src="Group 1.svg" alt="Left Banner">
</div>

<!-- RIGHT BANNER -->
<div class="side-banner right-banner">
    <img src="banner-right.jpg" alt="Right Banner">
</div>

<div class="container">

<h2><?= htmlspecialchars($chapter['chapter_name']); ?></h2>
<div class="subtitle"><?= htmlspecialchars($chapter['subject_name']); ?> • Chapter Practice</div>

<?php $i = $offset + 1; while($q = $questions->fetch_assoc()){ ?>
<div class="question" data-correct="<?= $q['correct_option']; ?>">

<p>Q<?= $i++; ?>. <?= htmlspecialchars($q['question']); ?></p>

<div class="options">
<?php foreach(['A','B','C','D'] as $opt):
$text = $q['option_'.strtolower($opt)];
?>
<label>
<input type="radio" name="q<?= $q['id']; ?>" value="<?= $opt; ?>">
<?= htmlspecialchars($text); ?>
</label>
<?php endforeach; ?>
</div>

<div class="result"></div>

<?php if(!empty($q['explanation'])){ ?>
<div class="explain-toggle" onclick="toggleExplain(this)">Show Explanation</div>
<div class="explanation">
<?= nl2br(htmlspecialchars($q['explanation'])); ?>
</div>
<?php } ?>

</div>
<?php } ?>

<div class="pagination">
<a class="page-btn <?= ($page<=1?'disabled':'') ?>" 
   href="?chapter_id=<?= $cid ?>&page=<?= $page-1 ?>">← Previous</a>

<a class="page-btn <?= ($page>=$total_pages?'disabled':'') ?>" 
   href="?chapter_id=<?= $cid ?>&page=<?= $page+1 ?>">Next →</a>
</div>

<a class="back" href="chapter_list.php">← Back to Chapters</a>

</div>

<script>
document.querySelectorAll('.question').forEach(q => {
    const correctLetter = q.dataset.correct; // e.g., 'A'
    const radios = q.querySelectorAll('input[type=radio]');
    const result = q.querySelector('.result');

    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.value === correctLetter) {
                result.innerHTML = "✅ Correct Answer";
                result.className = "result correct";
            } else {
                // Find the label text of the correct option
                const correctOptionText = Array.from(radios).find(r => r.value === correctLetter)
                                               .parentElement.textContent.trim();
                result.innerHTML = "❌ Wrong Answer | Correct Answer: " + correctOptionText;
                result.className = "result wrong";
            }
        });
    });
});


function toggleExplain(el){
    const exp = el.nextElementSibling;
    if(exp.style.display === "block"){
        exp.style.display = "none";
        el.innerText = "Show Explanation";
    }else{
        exp.style.display = "block";
        el.innerText = "Hide Explanation";
    }
}
</script>

</body>
</html>
