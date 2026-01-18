<?php
include "db_connect.php";

$sid   = intval($_GET['sid']);
$setid = intval($_GET['setid']);

// Fetch questions
$q = $conn->query("SELECT * FROM questions WHERE subject_id=$sid AND set_id=$setid");
$questions = [];
while($row = $q->fetch_assoc()){
    $questions[] = $row;
}
$total = count($questions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mock Test</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --white-bg: #ffffff;
        --blue-primary: #2196f3;
        --blue-light: #e3f2fd;
        --accent: #ff9800;
        --text-primary: #333333;
        --text-secondary: #666666;
        --border-color: #e0e0e0;
        --success: #4caf50;
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9f9f9;
        color: var(--text-primary);
        line-height: 1.6;
    }
    
    .container {
        display: flex;
        flex-direction: column;
        max-width: 1400px;
        margin: 0 auto;
        background: var(--white-bg);
        min-height: 100vh;
    }
    
    /* Header */
    .header {
        background-color: var(--blue-primary);
        color: white;
        padding: 1.2rem 2rem;
        box-shadow: var(--shadow);
        position: sticky;
        top: 0;
        z-index: 100;
    }
    
    .header h1 {
        font-weight: 600;
        font-size: 1.8rem;
        margin-bottom: 0.3rem;
    }
    
    .header .subtitle {
        font-weight: 300;
        opacity: 0.9;
        font-size: 0.95rem;
    }
    
    /* Main Content */
    .main-content {
        display: flex;
        flex: 1;
        flex-wrap: wrap;
    }
    
    /* Left Panel - Question Bubbles */
    .left-panel {
        width: 100%;
        max-width: 280px;
        background-color: var(--blue-light);
        padding: 1.5rem;
        border-right: 1px solid var(--border-color);
        overflow-y: auto;
    }
    
    .left-panel h3 {
        font-weight: 600;
        margin-bottom: 1.2rem;
        color: var(--blue-primary);
        font-size: 1.3rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(33, 150, 243, 0.2);
    }
    
    .bubble-container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.6rem;
        margin-bottom: 1.5rem;
    }
    
    .bubble {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background-color: white;
        color: var(--text-secondary);
        font-weight: 500;
        border: 2px solid transparent;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .bubble:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .bubble.attempted {
        background-color: var(--success);
        color: white;
        border-color: var(--success);
    }
    
    .bubble.current {
        background-color: var(--blue-primary);
        color: white;
        border-color: var(--blue-primary);
        transform: scale(1.05);
    }
    
    .progress-info {
        background-color: white;
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .progress-info h4 {
        font-weight: 500;
        margin-bottom: 0.8rem;
        color: var(--blue-primary);
    }
    
    .progress-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    /* Right Panel - Question Display */
    .right-panel {
        flex: 1;
        padding: 2rem;
        background-color: white;
        overflow-y: auto;
    }
    
    .question {
        margin-bottom: 2rem;
        padding: 1.5rem;
        border-radius: 12px;
        background-color: white;
        box-shadow: var(--shadow);
        border-left: 4px solid var(--blue-primary);
        display: none;
    }
    
    .question.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .question-text {
        font-size: 1.2rem;
        font-weight: 500;
        color: var(--text-primary);
        line-height: 1.5;
    }
    
    .question-number {
        background-color: var(--blue-primary);
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        flex-shrink: 0;
        margin-left: 1rem;
    }
    
    .options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .option {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .option:hover {
        background-color: var(--blue-light);
        border-color: var(--blue-primary);
    }
    
    .option input {
        margin-right: 1rem;
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
    
    .option-label {
        font-weight: 500;
        margin-right: 0.5rem;
        color: var(--blue-primary);
    }
    
    /* Navigation Buttons */
    .navigation {
        display: flex;
        justify-content: space-between;
        margin-top: 2.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }
    
    .nav-btn {
        padding: 0.8rem 1.8rem;
        border: none;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-prev {
        background-color: white;
        color: var(--blue-primary);
        border: 2px solid var(--blue-primary);
    }
    
    .btn-prev:hover {
        background-color: var(--blue-light);
    }
    
    .btn-next {
        background-color: var(--blue-primary);
        color: white;
    }
    
    .btn-next:hover {
        background-color: #0d8bf2;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(33, 150, 243, 0.3);
    }
    
    .btn-submit {
        background-color: var(--accent);
        color: white;
        padding: 0.8rem 2.2rem;
    }
    
    .btn-submit:hover {
        background-color: #e68900;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255, 152, 0, 0.3);
    }
    
    .timer {
        background-color: rgba(33, 150, 243, 0.1);
        padding: 0.8rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        color: var(--blue-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    /* Mobile Responsiveness */
    @media (max-width: 992px) {
        .main-content {
            flex-direction: column;
        }
        
        .left-panel {
            max-width: 100%;
            border-right: none;
            border-bottom: 1px solid var(--border-color);
        }
        
        .bubble-container {
            grid-template-columns: repeat(8, 1fr);
        }
        
        .navigation {
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .timer {
            order: -1;
            width: 100%;
            justify-content: center;
        }
    }
    
    @media (max-width: 768px) {
        .header {
            padding: 1rem;
        }
        
        .header h1 {
            font-size: 1.5rem;
        }
        
        .left-panel, .right-panel {
            padding: 1.2rem;
        }
        
        .bubble-container {
            grid-template-columns: repeat(6, 1fr);
        }
        
        .bubble {
            width: 38px;
            height: 38px;
        }
        
        .question-text {
            font-size: 1.1rem;
        }
        
        .nav-btn {
            padding: 0.7rem 1.4rem;
            font-size: 0.95rem;
        }
        
        .btn-submit {
            padding: 0.7rem 1.8rem;
        }
    }
    
    @media (max-width: 480px) {
        .bubble-container {
            grid-template-columns: repeat(5, 1fr);
        }
        
        .question-header {
            flex-direction: column;
            gap: 1rem;
        }
        
        .question-number {
            align-self: flex-start;
        }
        
        .navigation {
            flex-direction: column;
            align-items: stretch;
        }
        
        .nav-btn {
            width: 100%;
            justify-content: center;
        }
        
        .timer {
            order: 0;
        }
    }
</style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>Mock Test</h1>
        <div class="subtitle">Subject ID: <?= $sid ?> | Set ID: <?= $setid ?> | Total Questions: <?= $total ?></div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Left Panel: Question Bubbles -->
        <div class="left-panel">
            <h3>Questions</h3>
            <div class="bubble-container">
                <?php foreach($questions as $index => $qrow){ ?>
                    <div class="bubble" id="bubble-<?= $index ?>" onclick="showQuestion(<?= $index ?>)">
                        <?= $index+1 ?>
                    </div>
                <?php } ?>
            </div>
            
            <div class="progress-info">
                <h4>Progress</h4>
                <div class="progress-item">
                    <span>Total Questions:</span>
                    <span><?= $total ?></span>
                </div>
                <div class="progress-item">
                    <span>Attempted:</span>
                    <span id="attempted-count">0</span>
                </div>
                <div class="progress-item">
                    <span>Remaining:</span>
                    <span id="remaining-count"><?= $total ?></span>
                </div>
            </div>
        </div>

        <!-- Right Panel: Question Display -->
        <div class="right-panel">
            <form id="mockForm" action="result.php" method="post">
                <?php foreach($questions as $index => $qrow){ ?>
                    <div class="question" id="question-<?= $index ?>">
                        <div class="question-header">
                            <div class="question-text">
                                <?= $qrow['question'] ?>
                            </div>
                            <div class="question-number"><?= $index+1 ?></div>
                        </div>
                        
                        <div class="options">
                            <label class="option" onclick="markAttempted(<?= $index ?>)">
                                <input type="radio" name="ans[<?= $qrow['id'] ?>]" value="A">
                                <span class="option-label">A</span>
                                <span><?= $qrow['option_a'] ?></span>
                            </label>
                            
                            <label class="option" onclick="markAttempted(<?= $index ?>)">
                                <input type="radio" name="ans[<?= $qrow['id'] ?>]" value="B">
                                <span class="option-label">B</span>
                                <span><?= $qrow['option_b'] ?></span>
                            </label>
                            
                            <label class="option" onclick="markAttempted(<?= $index ?>)">
                                <input type="radio" name="ans[<?= $qrow['id'] ?>]" value="C">
                                <span class="option-label">C</span>
                                <span><?= $qrow['option_c'] ?></span>
                            </label>
                            
                            <label class="option" onclick="markAttempted(<?= $index ?>)">
                                <input type="radio" name="ans[<?= $qrow['id'] ?>]" value="D">
                                <span class="option-label">D</span>
                                <span><?= $qrow['option_d'] ?></span>
                            </label>
                        </div>
                    </div>
                <?php } ?>

                <div class="navigation">
                    <div class="timer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span id="timer-display">60:00</span>
                    </div>
                    
                    <button type="button" class="nav-btn btn-prev" onclick="prevQuestion()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                        Previous
                    </button>
                    
                    <button type="button" class="nav-btn btn-next" onclick="nextQuestion()">
                        Next
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                    
                    <button type="submit" class="nav-btn btn-submit">
                        Submit Exam
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let current = 0;
const total = <?= $total ?>;
let attempted = new Set();
let timeLeft = 60 * 60; // 60 minutes in seconds

// Timer functionality
function updateTimer() {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    document.getElementById('timer-display').textContent = 
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    if (timeLeft > 0) {
        timeLeft--;
    } else {
        // Auto-submit when time runs out
        document.getElementById('mockForm').submit();
    }
}

// Update timer every second
setInterval(updateTimer, 1000);

function showQuestion(index) {
    // Hide current question
    document.getElementById('question-'+current).classList.remove('active');
    document.getElementById('bubble-'+current).classList.remove('current');
    
    // Show new question
    document.getElementById('question-'+index).classList.add('active');
    document.getElementById('bubble-'+index).classList.add('current');
    
    current = index;
    
    // Update progress counts
    updateProgressCounts();
}

function nextQuestion() {
    if (current < total - 1) {
        showQuestion(current + 1);
    }
}

function prevQuestion() {
    if (current > 0) {
        showQuestion(current - 1);
    }
}

function markAttempted(index) {
    if (!attempted.has(index)) {
        attempted.add(index);
        document.getElementById('bubble-'+index).classList.add('attempted');
        updateProgressCounts();
    }
}

function updateProgressCounts() {
    const attemptedCount = attempted.size;
    const remainingCount = total - attemptedCount;
    
    document.getElementById('attempted-count').textContent = attemptedCount;
    document.getElementById('remaining-count').textContent = remainingCount;
}

// Initialize first question as active
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('question-0').classList.add('active');
    document.getElementById('bubble-0').classList.add('current');
    
    // Check for previously selected answers
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const questionId = this.name.match(/\[(\d+)\]/)[1];
            // Find the question index by looking for the radio button's parent question div
            let questionDiv = this.closest('.question');
            if (questionDiv) {
                const questionIndex = parseInt(questionDiv.id.split('-')[1]);
                markAttempted(questionIndex);
            }
        });
    });
    
    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowRight' || e.key === ' ') {
            nextQuestion();
        } else if (e.key === 'ArrowLeft') {
            prevQuestion();
        } else if (e.key >= '1' && e.key <= '9') {
            const num = parseInt(e.key) - 1;
            if (num < total) {
                showQuestion(num);
            }
        }
    });
});
</script>

</body>
</html>