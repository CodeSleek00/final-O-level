<?php
include "db_connect.php";

$answers = $_POST['ans'] ?? [];

$total_attempted = count($answers);
$correct = 0;
$wrong = 0;

$summary = [];

foreach($answers as $qid => $ans){
    $res = $conn->query("SELECT * FROM questions WHERE id=$qid")->fetch_assoc();
    
    $is_correct = $res['correct_option'] == $ans;
    if($is_correct){
        $correct++;
        $status = "Correct";
    } else {
        $wrong++;
        $status = "Wrong";
    }

    $summary[] = [
        'question' => $res['question'],
        'selected' => $ans,
        'correct'  => $res['correct_option'],
        'options'  => [
            'A' => $res['option_a'],
            'B' => $res['option_b'],
            'C' => $res['option_c'],
            'D' => $res['option_d']
        ],
        'status'   => $status
    ];
}

$setid = isset($_POST['setid']) ? intval($_POST['setid']) : 0;
$sid   = isset($_POST['sid']) ? intval($_POST['sid']) : 0;

$total_q_res = $conn->query("SELECT COUNT(*) as t FROM questions WHERE subject_id=$sid AND set_id=$setid")->fetch_assoc();
$total_q = $total_q_res['t'];

$unattempted = $total_q - $total_attempted;

// Calculate percentage
$percentage = $total_q > 0 ? round(($correct / $total_q) * 100, 2) : 0;

// Determine grade/status
if($percentage >= 90) {
    $grade = "Excellent";
    $grade_color = "#10B981";
} elseif($percentage >= 75) {
    $grade = "Good";
    $grade_color = "#3B82F6";
} elseif($percentage >= 50) {
    $grade = "Average";
    $grade_color = "#F59E0B";
} else {
    $grade = "Needs Improvement";
    $grade_color = "#EF4444";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Exam Result | Assessment Portal</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
    --primary-blue: #2563EB;
    --primary-blue-dark: #1D4ED8;
    --primary-blue-light: #60A5FA;
    --white-70: rgba(255, 255, 255, 0.95);
    --white-20: #F8FAFC;
    --accent-color: #F59E0B;
    --accent-dark: #D97706;
    --success-color: #10B981;
    --error-color: #EF4444;
    --text-dark: #1F2937;
    --text-light: #6B7280;
    --border-color: #E5E7EB;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #1E3A8A 0%, #3B82F6 100%);
    color: var(--text-dark);
    line-height: 1.6;
    min-height: 100vh;
    padding: 20px;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    background-color: var(--white-70);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

/* Header */
.header {
    background: linear-gradient(90deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
    color: white;
    padding: 30px;
    text-align: center;
    position: relative;
}

.header h1 {
    font-weight: 700;
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.header p {
    font-weight: 300;
    font-size: 1.1rem;
    opacity: 0.9;
}

.header-icon {
    font-size: 3rem;
    margin-bottom: 15px;
    color: var(--accent-color);
}

/* Summary Cards */
.summary-cards {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 30px;
    background-color: var(--white-20);
}

.summary-card {
    flex: 1;
    min-width: 220px;
    background-color: white;
    border-radius: 15px;
    padding: 25px 20px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s, box-shadow 0.3s;
    border-top: 5px solid transparent;
}

.summary-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.summary-card:nth-child(1) {
    border-top-color: var(--primary-blue);
}

.summary-card:nth-child(2) {
    border-top-color: var(--success-color);
}

.summary-card:nth-child(3) {
    border-top-color: var(--error-color);
}

.summary-card:nth-child(4) {
    border-top-color: var(--accent-color);
}

.card-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
}

.card-number {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.card-label {
    font-size: 1.1rem;
    color: var(--text-light);
    font-weight: 500;
}

/* Score Summary */
.score-summary {
    background: linear-gradient(135deg, var(--primary-blue-light) 0%, var(--primary-blue) 100%);
    color: white;
    border-radius: 15px;
    margin: 0 30px 30px;
    padding: 30px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
}

.score-circle {
    flex: 0 0 auto;
    position: relative;
    width: 180px;
    height: 180px;
    margin-right: 30px;
}

.circular-progress {
    width: 100%;
    height: 100%;
}

.circular-progress svg {
    width: 100%;
    height: 100%;
    transform: rotate(-90deg);
}

.circular-progress circle {
    fill: none;
    stroke-width: 10;
    stroke-linecap: round;
}

.circular-progress-bg {
    stroke: rgba(255, 255, 255, 0.2);
}

.circular-progress-fill {
    stroke: var(--accent-color);
    stroke-dasharray: 440;
    stroke-dashoffset: calc(440 - (440 * <?= $percentage ?>) / 100);
    transition: stroke-dashoffset 1s ease;
}

.score-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.score-percentage {
    font-size: 3rem;
    font-weight: 700;
    line-height: 1;
}

.score-label {
    font-size: 1.2rem;
    font-weight: 500;
    opacity: 0.9;
}

.score-details {
    flex: 1;
    min-width: 300px;
}

.score-details h3 {
    font-size: 2rem;
    margin-bottom: 15px;
    font-weight: 700;
}

.grade-badge {
    display: inline-block;
    background-color: <?= $grade_color ?>;
    color: white;
    padding: 8px 20px;
    border-radius: 50px;
    font-weight: 600;
    margin-bottom: 20px;
    font-size: 1.1rem;
}

.score-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.stat-item {
    background-color: rgba(255, 255, 255, 0.15);
    padding: 15px;
    border-radius: 10px;
    text-align: center;
}

.stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

/* Question Summary */
.question-summary {
    padding: 0 30px 40px;
}

.question-summary h3 {
    font-size: 1.8rem;
    margin-bottom: 25px;
    color: var(--primary-blue);
    padding-bottom: 10px;
    border-bottom: 2px solid var(--border-color);
}

.summary-table-container {
    overflow-x: auto;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
}

thead {
    background-color: var(--primary-blue);
    color: white;
}

th {
    padding: 18px 15px;
    text-align: left;
    font-weight: 600;
    font-size: 1.1rem;
}

td {
    padding: 18px 15px;
    border-bottom: 1px solid var(--border-color);
    vertical-align: top;
}

tbody tr {
    transition: background-color 0.2s;
}

tbody tr:hover {
    background-color: rgba(59, 130, 246, 0.05);
}

.status-badge {
    display: inline-block;
    padding: 6px 15px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-correct {
    background-color: rgba(16, 185, 129, 0.15);
    color: var(--success-color);
}

.status-wrong {
    background-color: rgba(239, 68, 68, 0.15);
    color: var(--error-color);
}

.status-unattempted {
    background-color: rgba(245, 158, 11, 0.15);
    color: var(--accent-dark);
}

.correct-answer {
    color: var(--success-color);
    font-weight: 600;
}

.your-answer {
    color: var(--error-color);
    font-weight: 600;
}

/* Actions */
.actions {
    display: flex;
    justify-content: center;
    gap: 20px;
    padding: 30px;
    background-color: var(--white-20);
    border-top: 1px solid var(--border-color);
}

.btn {
    padding: 15px 30px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1.1rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s;
    cursor: pointer;
    border: none;
    font-family: 'Poppins', sans-serif;
}

.btn-primary {
    background-color: var(--primary-blue);
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-blue-dark);
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
}

.btn-secondary {
    background-color: white;
    color: var(--primary-blue);
    border: 2px solid var(--primary-blue);
}

.btn-secondary:hover {
    background-color: rgba(37, 99, 235, 0.05);
    transform: translateY(-3px);
}

/* Footer */
.footer {
    text-align: center;
    padding: 20px;
    color: var(--text-light);
    font-size: 0.9rem;
    background-color: var(--white-20);
    border-top: 1px solid var(--border-color);
}

/* Responsive Styles */
@media (max-width: 992px) {
    .header h1 {
        font-size: 2rem;
    }
    
    .score-summary {
        flex-direction: column;
        text-align: center;
    }
    
    .score-circle {
        margin-right: 0;
        margin-bottom: 30px;
    }
    
    .score-details {
        text-align: center;
    }
}

@media (max-width: 768px) {
    body {
        padding: 10px;
    }
    
    .container {
        border-radius: 15px;
    }
    
    .header, .summary-cards, .score-summary, .question-summary, .actions {
        padding: 20px;
    }
    
    .header h1 {
        font-size: 1.8rem;
    }
    
    .summary-card {
        min-width: calc(50% - 20px);
    }
    
    .score-circle {
        width: 150px;
        height: 150px;
    }
    
    .score-percentage {
        font-size: 2.5rem;
    }
    
    th, td {
        padding: 12px 10px;
        font-size: 0.95rem;
    }
    
    .btn {
        padding: 12px 20px;
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .header h1 {
        font-size: 1.5rem;
    }
    
    .summary-card {
        min-width: 100%;
    }
    
    .card-number {
        font-size: 2.5rem;
    }
    
    .actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        <div class="header-icon">
            <i class="fas fa-trophy"></i>
        </div>
        <h1>Exam Results</h1>
        <p>Detailed summary of your performance</p>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="card-icon" style="color: var(--primary-blue);">
                <i class="fas fa-question-circle"></i>
            </div>
            <div class="card-number"><?= $total_q ?></div>
            <div class="card-label">Total Questions</div>
        </div>
        
        <div class="summary-card">
            <div class="card-icon" style="color: var(--success-color);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="card-number"><?= $correct ?></div>
            <div class="card-label">Correct Answers</div>
        </div>
        
        <div class="summary-card">
            <div class="card-icon" style="color: var(--error-color);">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="card-number"><?= $wrong ?></div>
            <div class="card-label">Wrong Answers</div>
        </div>
        
        <div class="summary-card">
            <div class="card-icon" style="color: var(--accent-color);">
                <i class="fas fa-clock"></i>
            </div>
            <div class="card-number"><?= $unattempted ?></div>
            <div class="card-label">Unattempted</div>
        </div>
    </div>

    <!-- Score Summary -->
    <div class="score-summary">
        <div class="score-circle">
            <div class="circular-progress">
                <svg>
                    <circle class="circular-progress-bg" cx="90" cy="90" r="80"></circle>
                    <circle class="circular-progress-fill" cx="90" cy="90" r="80"></circle>
                </svg>
            </div>
            <div class="score-text">
                <div class="score-percentage"><?= $percentage ?>%</div>
                <div class="score-label">Score</div>
            </div>
        </div>
        
        <div class="score-details">
            <h3>Your Performance Summary</h3>
            <div class="grade-badge"><?= $grade ?></div>
            <p>You answered <?= $correct ?> out of <?= $total_q ?> questions correctly.</p>
            
            <div class="score-stats">
                <div class="stat-item">
                    <div class="stat-value"><?= $total_attempted ?></div>
                    <div class="stat-label">Attempted</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?= $correct ?></div>
                    <div class="stat-label">Correct</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?= $wrong ?></div>
                    <div class="stat-label">Wrong</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?= $unattempted ?></div>
                    <div class="stat-label">Unattempted</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Question Summary -->
    <div class="question-summary">
        <h3><i class="fas fa-list-alt"></i> Question-by-Question Breakdown</h3>
        
        <div class="summary-table-container">
            <table>
                <thead>
                    <tr>
                        <th>Q.No.</th>
                        <th>Question</th>
                        <th>Your Answer</th>
                        <th>Correct Answer</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($summary as $index => $s): 
                        $your_ans_text = $s['options'][$s['selected']] ?? "Not Attempted";
                        $correct_ans_text = $s['options'][$s['correct']];
                        $status_class = $s['selected'] ? strtolower($s['status']) : "unattempted";
                        $status_text = $s['selected'] ? $s['status'] : "Unattempted";
                    ?>
                    <tr>
                        <td><strong><?= $index+1 ?></strong></td>
                        <td><?= $s['question'] ?></td>
                        <td>
                            <?php if($s['selected']): ?>
                                <span class="your-answer"><?= $your_ans_text ?> (<?= $s['selected'] ?>)</span>
                            <?php else: ?>
                                <span style="color: var(--text-light);">Not Attempted</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="correct-answer"><?= $correct_ans_text ?> (<?= $s['correct'] ?>)</span>
                        </td>
                        <td>
                            <span class="status-badge status-<?= $status_class ?>"><?= $status_text ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Actions -->
    <div class="actions">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Print Results
        </button>
        <button class="btn btn-secondary" onclick="window.location.href='exam.php'">
            <i class="fas fa-redo"></i> Take Another Test
        </button>
        <button class="btn btn-secondary" onclick="window.location.href='dashboard.php'">
            <i class="fas fa-home"></i> Back to Dashboard
        </button>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Result generated on <?= date('F j, Y, g:i a') ?> | Assessment Portal</p>
    </div>
</div>

<script>
// Animate the circular progress bar
document.addEventListener('DOMContentLoaded', function() {
    const progressFill = document.querySelector('.circular-progress-fill');
    // Already calculated in PHP, just ensure it's visible
    progressFill.style.opacity = 1;
});
</script>

</body>
</html>