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

/* ===== PAGINATION ===== */
$questions_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $questions_per_page;

// Get total questions count
$count_query = $conn->query("SELECT COUNT(*) as total FROM chapter_questions WHERE chapter_id = $cid");
$total_questions = $count_query->fetch_assoc()['total'];
$total_pages = ceil($total_questions / $questions_per_page);

/* ===== FETCH QUESTIONS FOR CURRENT PAGE ===== */
$questions = $conn->query("
    SELECT * FROM chapter_questions
    WHERE chapter_id = $cid
    LIMIT $offset, $questions_per_page
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 20px;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    position: relative;
}

.header {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: white;
    padding: 25px 30px;
    position: relative;
    overflow: hidden;
}

.header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 20px 20px;
    opacity: 0.3;
}

h2 {
    font-size: 28px;
    margin-bottom: 5px;
    position: relative;
    z-index: 1;
}

.subtitle {
    font-size: 14px;
    opacity: 0.9;
    position: relative;
    z-index: 1;
}

.questions-wrapper {
    padding: 30px;
}

.question-container {
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    border: 2px solid transparent;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.question-container:hover {
    border-color: #e0e7ff;
    transform: translateY(-2px);
}

.question-number {
    display: inline-block;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    text-align: center;
    line-height: 36px;
    font-weight: 600;
    margin-bottom: 15px;
    font-size: 14px;
}

.question-text {
    font-size: 18px;
    font-weight: 500;
    color: #1f2937;
    margin-bottom: 20px;
    line-height: 1.5;
}

.options-container {
    display: grid;
    gap: 12px;
    margin-bottom: 20px;
}

.option-label {
    display: flex;
    align-items: center;
    padding: 16px 20px;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
}

.option-label:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

.option-label.selected {
    border-width: 2px;
}

.option-label.correct {
    background: #d1fae5;
    border-color: #10b981;
    color: #065f46;
}

.option-label.wrong {
    background: #fee2e2;
    border-color: #ef4444;
    color: #7f1d1d;
}

.option-radio {
    display: none;
}

.option-letter {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    margin-right: 15px;
    flex-shrink: 0;
    transition: all 0.2s ease;
}

.option-label:hover .option-letter {
    background: #cbd5e1;
}

.option-label.correct .option-letter {
    background: #10b981;
    color: white;
}

.option-label.wrong .option-letter {
    background: #ef4444;
    color: white;
}

.option-text {
    flex-grow: 1;
    font-size: 16px;
}

.feedback {
    margin-top: 15px;
    padding: 15px;
    border-radius: 10px;
    display: none;
    animation: slideIn 0.3s ease;
}

.feedback.show {
    display: block;
}

.feedback.correct-feedback {
    background: #d1fae5;
    border-left: 4px solid #10b981;
}

.feedback.wrong-feedback {
    background: #fee2e2;
    border-left: 4px solid #ef4444;
}

.feedback-icon {
    font-size: 18px;
    margin-right: 10px;
}

.explanation-toggle {
    position: absolute;
    bottom: 20px;
    right: 25px;
    background: #3b82f6;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 2;
}

.explanation-toggle:hover {
    background: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.explanation {
    display: none;
    margin-top: 20px;
    padding: 20px;
    background: #f0f9ff;
    border-radius: 10px;
    border-left: 4px solid #3b82f6;
    animation: fadeIn 0.3s ease;
}

.explanation.show {
    display: block;
}

.explanation h4 {
    color: #1e40af;
    margin-bottom: 10px;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.explanation-content {
    color: #374151;
    line-height: 1.6;
    font-size: 15px;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    padding: 25px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}

.page-btn {
    background: white;
    border: 2px solid #e2e8f0;
    color: #4b5563;
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.page-btn:hover {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(37, 99, 235, 0.2);
}

.page-btn:disabled,
.page-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
    background: white;
    color: #4b5563;
    border-color: #e2e8f0;
}

.page-info {
    font-size: 14px;
    color: #6b7280;
    font-weight: 500;
}

.back-link {
    position: absolute;
    top: 25px;
    right: 30px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    z-index: 1;
}

.back-link:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-1px);
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@media (max-width: 768px) {
    .container {
        margin: 10px;
        border-radius: 15px;
    }
    
    .header {
        padding: 20px;
    }
    
    h2 {
        font-size: 24px;
    }
    
    .questions-wrapper {
        padding: 20px;
    }
    
    .question-container {
        padding: 20px;
    }
    
    .back-link {
        position: relative;
        top: 0;
        right: 0;
        margin-top: 15px;
        display: inline-block;
    }
    
    .explanation-toggle {
        position: relative;
        bottom: 0;
        right: 0;
        margin-top: 15px;
        width: 100%;
        text-align: center;
    }
}
</style>
</head>

<body>

<div class="container">
    <div class="header">
        <h2><?= htmlspecialchars($chapter['chapter_name']); ?></h2>
        <div class="subtitle"><?= htmlspecialchars($chapter['subject_name']); ?> • Page <?= $page ?> of <?= $total_pages ?></div>
        <a class="back-link" href="chapter_list.php">← Back to Chapters</a>
    </div>

    <div class="questions-wrapper">
        <form id="practiceForm">
            <?php 
            $question_number = $offset + 1;
            while($q = $questions->fetch_assoc()): 
            ?>
            <div class="question-container" data-question-id="<?= $q['id']; ?>">
                <div class="question-number"><?= $question_number++; ?></div>
                <div class="question-text"><?= htmlspecialchars($q['question']); ?></div>
                
                <div class="options-container">
                    <?php foreach(['A','B','C','D'] as $opt):
                        $text = $q['option_'.strtolower($opt)];
                    ?>
                    <label class="option-label" data-option="<?= $opt; ?>">
                        <input type="radio" 
                               class="option-radio" 
                               name="ans[<?= $q['id']; ?>]" 
                               value="<?= $opt; ?>">
                        <span class="option-letter"><?= $opt; ?></span>
                        <span class="option-text"><?= htmlspecialchars($text); ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>

                <div class="feedback" id="feedback-<?= $q['id']; ?>">
                    <!-- Feedback will be inserted here by JavaScript -->
                </div>

                <?php if(!empty($q['explanation'])): ?>
                <button type="button" class="explanation-toggle" onclick="toggleExplanation(<?= $q['id']; ?>)">
                    📖 Show Explanation
                </button>
                
                <div class="explanation" id="explanation-<?= $q['id']; ?>">
                    <h4>💡 Explanation</h4>
                    <div class="explanation-content"><?= htmlspecialchars($q['explanation']); ?></div>
                </div>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </form>
    </div>

    <?php if($total_pages > 1): ?>
    <div class="pagination">
        <?php if($page > 1): ?>
        <a href="?chapter_id=<?= $cid ?>&page=<?= $page-1 ?>" class="page-btn">← Previous</a>
        <?php else: ?>
        <span class="page-btn disabled">← Previous</span>
        <?php endif; ?>
        
        <span class="page-info">Page <?= $page ?> of <?= $total_pages ?></span>
        
        <?php if($page < $total_pages): ?>
        <a href="?chapter_id=<?= $cid ?>&page=<?= $page+1 ?>" class="page-btn">Next →</a>
        <?php else: ?>
        <span class="page-btn disabled">Next →</span>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    // Handle radio button click for instant feedback
    $('.option-radio').on('change', function() {
        const questionId = $(this).attr('name').match(/\[(\d+)\]/)[1];
        const selectedOption = $(this).val();
        const $questionContainer = $(this).closest('.question-container');
        const $feedback = $('#feedback-' + questionId);
        
        // Reset all options for this question
        $questionContainer.find('.option-label').removeClass('selected correct wrong');
        
        // Mark selected option
        const $selectedLabel = $(this).closest('.option-label');
        $selectedLabel.addClass('selected');
        
        // Get correct answer from server via AJAX
        $.ajax({
            url: 'check_answer.php',
            method: 'POST',
            data: {
                question_id: questionId,
                selected_option: selectedOption
            },
            success: function(response) {
                const result = JSON.parse(response);
                
                if (result.success) {
                    if (result.is_correct) {
                        $selectedLabel.addClass('correct');
                        $feedback.html(`
                            <div class="feedback correct-feedback show">
                                <span class="feedback-icon">✅</span>
                                <strong>Correct!</strong> Excellent answer.
                            </div>
                        `);
                    } else {
                        $selectedLabel.addClass('wrong');
                        // Highlight correct option
                        $questionContainer.find(`[data-option="${result.correct_answer}"]`).addClass('correct');
                        
                        $feedback.html(`
                            <div class="feedback wrong-feedback show">
                                <span class="feedback-icon">❌</span>
                                <strong>Incorrect.</strong> The correct answer is <strong>${result.correct_answer}</strong>
                            </div>
                        `);
                    }
                    
                    // Auto-show explanation if available
                    const $explanation = $('#explanation-' + questionId);
                    if ($explanation.length && !$explanation.hasClass('show')) {
                        setTimeout(() => {
                            $explanation.addClass('show');
                            $questionContainer.find('.explanation-toggle').text('📖 Hide Explanation');
                        }, 1000);
                    }
                }
            },
            error: function() {
                alert('Error checking answer. Please try again.');
            }
        });
    });
});

function toggleExplanation(questionId) {
    const $explanation = $('#explanation-' + questionId);
    const $toggleBtn = $explanation.siblings('.explanation-toggle');
    
    if ($explanation.hasClass('show')) {
        $explanation.removeClass('show');
        $toggleBtn.text('📖 Show Explanation');
    } else {
        $explanation.addClass('show');
        $toggleBtn.text('📖 Hide Explanation');
    }
}

// Keyboard shortcuts
$(document).keydown(function(e) {
    // Number keys 1-4 for selecting options
    if (e.key >= '1' && e.key <= '4') {
        const optionLetters = ['A', 'B', 'C', 'D'];
        const selectedLetter = optionLetters[parseInt(e.key) - 1];
        
        // Find the first unanswered question
        const $unansweredQuestion = $('.question-container').filter(function() {
            return !$(this).find('.option-radio:checked').length;
        }).first();
        
        if ($unansweredQuestion.length) {
            const $radio = $unansweredQuestion.find(`[value="${selectedLetter}"]`);
            if ($radio.length) {
                $radio.prop('checked', true).trigger('change');
            }
        }
    }
    
    // E key to toggle explanation for current question
    if (e.key === 'e' || e.key === 'E') {
        const $currentQuestion = $('.option-radio:checked').closest('.question-container');
        if ($currentQuestion.length) {
            const questionId = $currentQuestion.data('question-id');
            toggleExplanation(questionId);
        }
    }
});
</script>

<?php
// Create check_answer.php file if it doesn't exist
// Place this in a separate file named check_answer.php
?>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>