<?php
include '../db_connect.php';

$paper_id = isset($_GET['paper_id']) ? intval($_GET['paper_id']) : 0;
if(!$paper_id){ die("Invalid Paper"); }

/* Pagination */
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page-1)*$limit;

/* Paper Info */
$paper_q = $conn->query("
    SELECT p.*, s.subject_name 
    FROM pyq_papers p
    JOIN subjects s ON p.subject_id = s.id
    WHERE p.id=$paper_id
");
$paper = $paper_q->fetch_assoc();

/* Total */
$total_q = $conn->query("SELECT COUNT(*) total FROM pyq_questions WHERE paper_id=$paper_id");
$total = $total_q->fetch_assoc()['total'];
$total_pages = ceil($total/$limit);

/* Questions */
$questions = $conn->query("
    SELECT * FROM pyq_questions
    WHERE paper_id=$paper_id
    LIMIT $limit OFFSET $offset
");
?>

<!DOCTYPE html>
<html>
<head>
<title><?= $paper['paper_title'] ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{font-family:Poppins;background:#f4f6f9;margin:0}
.container{max-width:900px;margin:40px auto;background:#fff;padding:25px;border-radius:18px}
.question{margin-bottom:30px}
.options label{
    display:block;
    padding:10px;
    border:1px solid #ddd;
    border-radius:8px;
    margin-bottom:8px;
    cursor:pointer;
}
.correct{background:#ecfdf5;border:1px solid #10b981;padding:8px}
.wrong{background:#fef2f2;border:1px solid #ef4444;padding:8px}
.explain-toggle{text-align:right;font-size:13px;color:#2563eb;cursor:pointer}
.explanation{display:none;background:#f1f5f9;padding:10px;border-radius:8px;margin-top:8px}
.pagination{display:flex;justify-content:space-between;margin-top:30px}
.page-btn{background:#0d6efd;color:#fff;padding:10px 22px;border-radius:30px;text-decoration:none}
.disabled{opacity:.4;pointer-events:none}
</style>
</head>

<body>
<div class="container">

<h2><?= $paper['paper_title'] ?></h2>
<p><?= $paper['subject_name'] ?> • <?= $paper['exam_year'] ?></p>

<?php $i=$offset+1; while($q=$questions->fetch_assoc()){ ?>
<div class="question" data-correct="<?= $q['correct_option'] ?>">

<p>Q<?= $i++ ?>. <?= htmlspecialchars($q['question']) ?></p>

<div class="options">
<?php foreach(['A','B','C','D'] as $o): ?>
<label>
<input type="radio" name="q<?= $q['id'] ?>" value="<?= $o ?>">
<?= htmlspecialchars($q['option_'.strtolower($o)]) ?>
</label>
<?php endforeach; ?>
</div>

<div class="result"></div>

<?php if($q['explanation']){ ?>
<div class="explain-toggle" onclick="toggle(this)">Show Explanation</div>
<div class="explanation"><?= htmlspecialchars($q['explanation']) ?></div>
<?php } ?>

</div>
<?php } ?>

<div class="pagination">
<a class="page-btn <?= $page<=1?'disabled':'' ?>" href="?paper_id=<?= $paper_id ?>&page=<?= $page-1 ?>">← Prev</a>
<a class="page-btn <?= $page>=$total_pages?'disabled':'' ?>" href="?paper_id=<?= $paper_id ?>&page=<?= $page+1 ?>">Next →</a>
</div>

</div>

<script>
document.querySelectorAll('.question').forEach(q=>{
    const correct=q.dataset.correct;
    const res=q.querySelector('.result');
    q.querySelectorAll('input').forEach(r=>{
        r.addEventListener('change',()=>{
            if(r.value===correct){
                res.className='correct';
                res.innerHTML='✅ Correct';
            }else{
                res.className='wrong';
                res.innerHTML='❌ Wrong | Correct: '+correct;
            }
        });
    });
});
function toggle(el){
    const e=el.nextElementSibling;
    e.style.display=e.style.display==='block'?'none':'block';
    el.innerText=e.style.display==='block'?'Hide Explanation':'Show Explanation';
}
</script>

</body>
</html>
