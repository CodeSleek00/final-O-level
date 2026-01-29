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
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    background: #f8fafc;
    color: #334155;
    line-height: 1.6;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.header {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    border: 1px solid #e2e8f0;
}

.header h1 {
    font-size: 24px;
    color: #1e293b;
    margin-bottom: 8px;
    font-weight: 600;
}

.meta {
    display: flex;
    gap: 20px;
    color: #64748b;
    font-size: 14px;
    margin-top: 12px;
}

.meta span {
    background: #f1f5f9;
    padding: 4px 12px;
    border-radius: 20px;
}

.question-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    border: 1px solid #e2e8f0;
}

.question-number {
    color: #3b82f6;
    font-weight: 600;
    margin-bottom: 12px;
    font-size: 14px;
}

.question-text {
    font-size: 16px;
    margin-bottom: 20px;
    color: #1e293b;
}

.options {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

.option {
    padding: 14px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
}

.option:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
}

.option input {
    margin-right: 12px;
    accent-color: #3b82f6;
}

.result {
    padding: 12px 16px;
    border-radius: 8px;
    margin-top: 10px;
    font-size: 14px;
    display: none;
}

.result.correct {
    background: #f0f9ff;
    color: #0369a1;
    border: 1px solid #bae6fd;
}

.result.wrong {
    background: #fef2f2;
    color: #b91c1c;
    border: 1px solid #fecaca;
}

.explanation-toggle {
    color: #3b82f6;
    font-size: 14px;
    cursor: pointer;
    margin-top: 15px;
    display: inline-block;
    font-weight: 500;
}

.explanation {
    background: #f8fafc;
    padding: 16px;
    border-radius: 8px;
    margin-top: 12px;
    border-left: 3px solid #3b82f6;
    display: none;
}

.pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 40px;
    padding: 20px 0;
}

.page-btn {
    padding: 10px 24px;
    background: #3b82f6;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    transition: background 0.2s;
    border: none;
    cursor: pointer;
}

.page-btn:hover {
    background: #2563eb;
}

.page-btn.disabled {
    background: #cbd5e1;
    cursor: not-allowed;
}

.page-info {
    color: #64748b;
    font-size: 14px;
}

@media (max-width: 640px) {
    .container {
        padding: 15px;
    }
    
    .header, .question-card {
        padding: 20px;
    }
    
    .pagination {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
}
</style>
</head>

<body>
<div class="container">

<div class="header">
    <h1><?= htmlspecialchars($paper['paper_title']) ?></h1>
    <div class="meta">
        <span><?= htmlspecialchars($paper['subject_name']) ?></span>
        <span><?= htmlspecialchars($paper['exam_year']) ?></span>
    </div>
</div>

<?php $i=$offset+1; while($q=$questions->fetch_assoc()){ ?>
<div class="question-card" data-correct="<?= $q['correct_option'] ?>">
    <div class="question-number">Question <?= $i++ ?></div>
    <div class="question-text"><?= htmlspecialchars($q['question']) ?></div>
    
    <div class="options">
        <?php foreach(['A','B','C','D'] as $o): ?>
        <label class="option">
            <input type="radio" name="q<?= $q['id'] ?>" value="<?= $o ?>">
            <?= htmlspecialchars($q['option_'.strtolower($o)]) ?>
        </label>
        <?php endforeach; ?>
    </div>
    
    <div class="result"></div>
    
    <?php if($q['explanation']){ ?>
    <div class="explanation-toggle" onclick="toggleExplanation(this)">Show Explanation</div>
    <div class="explanation"><?= htmlspecialchars($q['explanation']) ?></div>
    <?php } ?>
</div>
<?php } ?>

<div class="pagination">
    <a class="page-btn <?= $page<=1?'disabled':'' ?>" 
       href="?paper_id=<?= $paper_id ?>&page=<?= $page-1 ?>">
        Previous
    </a>
    
    <div class="page-info">
        Page <?= $page ?> of <?= $total_pages ?>
    </div>
    
    <a class="page-btn <?= $page>=$total_pages?'disabled':'' ?>" 
       href="?paper_id=<?= $paper_id ?>&page=<?= $page+1 ?>">
        Next
    </a>
</div>

</div>

<script>
document.querySelectorAll('.question-card').forEach(card => {
    const correctAnswer = card.dataset.correct;
    const resultDiv = card.querySelector('.result');
    
    card.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.value === correctAnswer) {
                resultDiv.textContent = '✓ Correct Answer';
                resultDiv.className = 'result correct';
            } else {
                resultDiv.textContent = `✗ Incorrect. Correct answer is ${correctAnswer}`;
                resultDiv.className = 'result wrong';
            }
            resultDiv.style.display = 'block';
        });
    });
});

function toggleExplanation(element) {
    const explanation = element.nextElementSibling;
    const isHidden = explanation.style.display !== 'block';
    
    explanation.style.display = isHidden ? 'block' : 'none';
    element.textContent = isHidden ? 'Hide Explanation' : 'Show Explanation';
}
</script>

</body>
</html>