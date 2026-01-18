<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Exam Result - <?= htmlspecialchars($subject_name) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3a0ca3;
        --success-color: #4cc9f0;
        --danger-color: #f72585;
        --warning-color: #f8961e;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --gray-color: #6c757d;
        --correct-color: #06d6a0;
        --wrong-color: #ef476f;
        --not-attempted: #adb5bd;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        --radius: 12px;
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        color: var(--dark-color);
        line-height: 1.6;
        min-height: 100vh;
        padding: 20px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
        padding: 20px;
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }

    .header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(to right, var(--primary-color), var(--success-color));
    }

    .header h1 {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 10px;
        font-weight: 700;
    }

    .header .subtitle {
        font-size: 1.1rem;
        color: var(--gray-color);
        margin-bottom: 20px;
    }

    .result-badge {
        display: inline-block;
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 600;
        margin-top: 10px;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }

    .main-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    @media (max-width: 992px) {
        .main-content {
            grid-template-columns: 1fr;
        }
    }

    .card {
        background: white;
        border-radius: var(--radius);
        padding: 25px;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 1.4rem;
        color: var(--primary-color);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid rgba(67, 97, 238, 0.1);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i {
        color: var(--secondary-color);
    }

    /* Score Cards */
    .score-cards {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .score-cards {
            grid-template-columns: 1fr;
        }
    }

    .score-card {
        background: white;
        border-radius: var(--radius);
        padding: 25px;
        box-shadow: var(--shadow);
        text-align: center;
        transition: var(--transition);
    }

    .score-card:hover {
        transform: translateY(-5px);
    }

    .score-card.correct {
        border-top: 4px solid var(--correct-color);
    }

    .score-card.wrong {
        border-top: 4px solid var(--wrong-color);
    }

    .score-card.attempted {
        border-top: 4px solid var(--primary-color);
    }

    .score-card.unattempted {
        border-top: 4px solid var(--not-attempted);
    }

    .score-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        display: inline-block;
        width: 70px;
        height: 70px;
        line-height: 70px;
        border-radius: 50%;
    }

    .score-card.correct .score-icon {
        background: rgba(6, 214, 160, 0.1);
        color: var(--correct-color);
    }

    .score-card.wrong .score-icon {
        background: rgba(239, 71, 111, 0.1);
        color: var(--wrong-color);
    }

    .score-card.attempted .score-icon {
        background: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
    }

    .score-card.unattempted .score-icon {
        background: rgba(173, 181, 189, 0.1);
        color: var(--not-attempted);
    }

    .score-value {
        font-size: 2.8rem;
        font-weight: 700;
        margin: 10px 0;
    }

    .score-card.correct .score-value {
        color: var(--correct-color);
    }

    .score-card.wrong .score-value {
        color: var(--wrong-color);
    }

    .score-card.attempted .score-value {
        color: var(--primary-color);
    }

    .score-card.unattempted .score-value {
        color: var(--not-attempted);
    }

    .score-label {
        font-size: 1rem;
        color: var(--gray-color);
        font-weight: 500;
    }

    /* Percentage Circle */
    .percentage-circle {
        text-align: center;
        padding: 20px;
    }

    .percentage-value {
        font-size: 3rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-top: 15px;
    }

    .percentage-label {
        color: var(--gray-color);
        font-size: 1.1rem;
        margin-top: 5px;
    }

    /* Chart Container */
    .chart-container {
        height: 300px;
        position: relative;
        margin: 20px 0;
    }

    /* Performance Summary */
    .performance-summary {
        margin-top: 20px;
    }

    .performance-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .performance-item:last-child {
        border-bottom: none;
    }

    .performance-label {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .performance-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .performance-dot.correct {
        background: var(--correct-color);
    }

    .performance-dot.wrong {
        background: var(--wrong-color);
    }

    .performance-dot.unattempted {
        background: var(--not-attempted);
    }

    .performance-value {
        font-weight: 600;
    }

    /* Detailed Summary Table */
    .detailed-summary {
        margin-top: 40px;
    }

    .summary-table-container {
        overflow-x: auto;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        background: white;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    thead {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        color: white;
    }

    th {
        padding: 18px 15px;
        text-align: left;
        font-weight: 600;
        font-size: 1rem;
    }

    tbody tr {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: var(--transition);
    }

    tbody tr:hover {
        background-color: rgba(67, 97, 238, 0.03);
    }

    td {
        padding: 16px 15px;
        vertical-align: top;
    }

    .question-cell {
        max-width: 350px;
        word-wrap: break-word;
    }

    .answer-cell {
        font-weight: 500;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-correct {
        background: rgba(6, 214, 160, 0.15);
        color: var(--correct-color);
    }

    .status-wrong {
        background: rgba(239, 71, 111, 0.15);
        color: var(--wrong-color);
    }

    .answer-icon {
        display: inline-block;
        width: 24px;
        height: 24px;
        line-height: 24px;
        text-align: center;
        border-radius: 50%;
        margin-right: 8px;
        font-weight: 600;
    }

    .correct-answer-icon {
        background: var(--correct-color);
        color: white;
    }

    .wrong-answer-icon {
        background: var(--wrong-color);
        color: white;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 40px 0;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 14px 30px;
        border: none;
        border-radius: var(--radius);
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 180px;
        justify-content: center;
    }

    .btn-retake {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        color: white;
    }

    .btn-retake:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(67, 97, 238, 0.3);
    }

    .btn-dashboard {
        background: white;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    .btn-dashboard:hover {
        background: rgba(67, 97, 238, 0.05);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .btn-review {
        background: linear-gradient(to right, var(--success-color), #06d6a0);
        color: white;
    }

    .btn-review:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(76, 201, 240, 0.3);
    }

    /* Footer */
    .footer {
        text-align: center;
        margin-top: 40px;
        padding: 20px;
        color: var(--gray-color);
        font-size: 0.9rem;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        body {
            padding: 10px;
        }
        
        .header h1 {
            font-size: 2rem;
        }
        
        .score-value {
            font-size: 2.2rem;
        }
        
        .percentage-value {
            font-size: 2.5rem;
        }
        
        .action-btn {
            min-width: 100%;
        }
        
        th, td {
            padding: 12px 10px;
            font-size: 0.9rem;
        }
    }

    /* Animation for result cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .score-card, .card {
        animation: fadeInUp 0.5s ease forwards;
    }

    .score-card:nth-child(2) { animation-delay: 0.1s; }
    .score-card:nth-child(3) { animation-delay: 0.2s; }
    .score-card:nth-child(4) { animation-delay: 0.3s; }
</style>
</head>
<body>

<?php
// Calculate additional metrics
$percentage = $total_attempted > 0 ? round(($correct / $total_attempted) * 100, 2) : 0;
$overall_percentage = $total_q > 0 ? round(($correct / $total_q) * 100, 2) : 0;
$unattempted = $total_q - $total_attempted;

// Fetch subject name
$subject_name = "Subject";
if($sid > 0) {
    $subject_query = $conn->query("SELECT subject_name FROM subjects WHERE id=$sid");
    if($subject_query->num_rows > 0) {
        $subject_name = $subject_query->fetch_assoc()['subject_name'];
    }
}

// Performance message based on score
if ($percentage >= 80) {
    $performance_message = "Excellent Performance!";
    $performance_class = "excellent";
} elseif ($percentage >= 60) {
    $performance_message = "Good Performance!";
    $performance_class = "good";
} elseif ($percentage >= 40) {
    $performance_message = "Average Performance";
    $performance_class = "average";
} else {
    $performance_message = "Needs Improvement";
    $performance_class = "poor";
}
?>

<div class="container">
    <!-- Header -->
    <div class="header">
        <h1><i class="fas fa-chart-line"></i> Exam Results</h1>
        <div class="subtitle">
            Subject: <strong><?= htmlspecialchars($subject_name) ?></strong> | 
            Test Set: <?= $setid ?> | 
            Date: <?= date('F j, Y') ?>
        </div>
        <div class="result-badge">
            <i class="fas fa-medal"></i> <?= $performance_message ?>
        </div>
    </div>

    <!-- Score Cards -->
    <div class="score-cards">
        <div class="score-card correct">
            <div class="score-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="score-value"><?= $correct ?></div>
            <div class="score-label">Correct Answers</div>
        </div>
        
        <div class="score-card wrong">
            <div class="score-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="score-value"><?= $wrong ?></div>
            <div class="score-label">Wrong Answers</div>
        </div>
        
        <div class="score-card attempted">
            <div class="score-icon">
                <i class="fas fa-pen-alt"></i>
            </div>
            <div class="score-value"><?= $total_attempted ?></div>
            <div class="score-label">Attempted</div>
        </div>
        
        <div class="score-card unattempted">
            <div class="score-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <div class="score-value"><?= $unattempted ?></div>
            <div class="score-label">Unattempted</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Left Column: Charts -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-chart-pie"></i> Performance Overview
            </div>
            
            <div class="chart-container">
                <canvas id="performanceChart"></canvas>
            </div>
            
            <div class="percentage-circle">
                <div class="percentage-value"><?= $percentage ?>%</div>
                <div class="percentage-label">Accuracy (Based on attempted questions)</div>
            </div>
            
            <div class="performance-summary">
                <div class="performance-item">
                    <div class="performance-label">
                        <span class="performance-dot correct"></span>
                        <span>Correct Answers</span>
                    </div>
                    <div class="performance-value"><?= $correct ?> (<?= $total_attempted > 0 ? round(($correct/$total_attempted)*100, 1) : 0 ?>%)</div>
                </div>
                <div class="performance-item">
                    <div class="performance-label">
                        <span class="performance-dot wrong"></span>
                        <span>Wrong Answers</span>
                    </div>
                    <div class="performance-value"><?= $wrong ?> (<?= $total_attempted > 0 ? round(($wrong/$total_attempted)*100, 1) : 0 ?>%)</div>
                </div>
                <div class="performance-item">
                    <div class="performance-label">
                        <span class="performance-dot unattempted"></span>
                        <span>Unattempted</span>
                    </div>
                    <div class="performance-value"><?= $unattempted ?> (<?= $total_q > 0 ? round(($unattempted/$total_q)*100, 1) : 0 ?>%)</div>
                </div>
            </div>
        </div>

        <!-- Right Column: Detailed Metrics -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-chart-bar"></i> Detailed Metrics
            </div>
            
            <div class="chart-container">
                <canvas id="detailedChart"></canvas>
            </div>
            
            <div class="performance-summary">
                <div class="performance-item">
                    <span>Total Questions:</span>
                    <span class="performance-value"><?= $total_q ?></span>
                </div>
                <div class="performance-item">
                    <span>Attempted Questions:</span>
                    <span class="performance-value"><?= $total_attempted ?> (<?= $total_q > 0 ? round(($total_attempted/$total_q)*100, 1) : 0 ?>%)</span>
                </div>
                <div class="performance-item">
                    <span>Overall Score:</span>
                    <span class="performance-value"><?= $correct ?>/<?= $total_q ?></span>
                </div>
                <div class="performance-item">
                    <span>Overall Percentage:</span>
                    <span class="performance-value"><?= $overall_percentage ?>%</span>
                </div>
                <div class="performance-item">
                    <span>Accuracy Rate:</span>
                    <span class="performance-value"><?= $percentage ?>%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Summary Table -->
    <div class="detailed-summary">
        <div class="card">
            <div class="card-title">
                <i class="fas fa-list-alt"></i> Question-wise Summary
            </div>
            
            <div class="summary-table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Q No.</th>
                            <th>Question</th>
                            <th>Your Answer</th>
                            <th>Correct Answer</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($summary as $index => $s){ 
                            $your_ans_text = $s['options'][$s['selected']] ?? "Not Attempted";
                            $correct_ans_text = $s['options'][$s['correct']];
                            $is_correct = $s['status'] == 'Correct';
                        ?>
                        <tr>
                            <td><strong><?= $index+1 ?></strong></td>
                            <td class="question-cell"><?= htmlspecialchars($s['question']) ?></td>
                            <td class="answer-cell">
                                <?php if($s['selected']): ?>
                                    <span class="answer-icon <?= $is_correct ? 'correct-answer-icon' : 'wrong-answer-icon' ?>">
                                        <?= $s['selected'] ?>
                                    </span>
                                    <?= htmlspecialchars($your_ans_text) ?>
                                <?php else: ?>
                                    <span style="color: var(--not-attempted);">
                                        <i class="fas fa-minus-circle"></i> Not Attempted
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="answer-cell">
                                <span class="answer-icon correct-answer-icon">
                                    <?= $s['correct'] ?>
                                </span>
                                <?= htmlspecialchars($correct_ans_text) ?>
                            </td>
                            <td>
                                <span class="status-badge status-<?= strtolower($s['status']) ?>">
                                    <?php if($is_correct): ?>
                                        <i class="fas fa-check"></i> Correct
                                    <?php else: ?>
                                        <i class="fas fa-times"></i> Wrong
                                    <?php endif; ?>
                                </span>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="action-btn btn-retake" onclick="retakeExam()">
            <i class="fas fa-redo"></i> Retake Exam
        </button>
        <button class="action-btn btn-review" onclick="reviewAnswers()">
            <i class="fas fa-eye"></i> Review Answers
        </button>
        <button class="action-btn btn-dashboard" onclick="goToDashboard()">
            <i class="fas fa-tachometer-alt"></i> Back to Dashboard
        </button>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© <?= date('Y') ?> Mock Test Platform. All rights reserved.</p>
        <p>Result generated on <?= date('F j, Y, g:i a') ?></p>
    </div>
</div>

<script>
// Performance Chart (Pie Chart)
const performanceCtx = document.getElementById('performanceChart').getContext('2d');
const performanceChart = new Chart(performanceCtx, {
    type: 'doughnut',
    data: {
        labels: ['Correct', 'Wrong', 'Unattempted'],
        datasets: [{
            data: [<?= $correct ?>, <?= $wrong ?>, <?= $unattempted ?>],
            backgroundColor: [
                'rgba(6, 214, 160, 0.8)',
                'rgba(239, 71, 111, 0.8)',
                'rgba(173, 181, 189, 0.8)'
            ],
            borderColor: [
                'rgba(6, 214, 160, 1)',
                'rgba(239, 71, 111, 1)',
                'rgba(173, 181, 189, 1)'
            ],
            borderWidth: 2,
            hoverOffset: 15
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    font: {
                        size: 13,
                        family: "'Poppins', sans-serif"
                    },
                    color: '#333'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                titleFont: {
                    family: "'Poppins', sans-serif"
                },
                bodyFont: {
                    family: "'Poppins', sans-serif"
                },
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.raw || 0;
                        const total = <?= $total_q ?>;
                        const percentage = Math.round((value / total) * 100);
                        return `${label}: ${value} (${percentage}%)`;
                    }
                }
            }
        },
        cutout: '70%'
    }
});

// Detailed Chart (Bar Chart)
const detailedCtx = document.getElementById('detailedChart').getContext('2d');
const detailedChart = new Chart(detailedCtx, {
    type: 'bar',
    data: {
        labels: ['Correct', 'Wrong', 'Attempted', 'Unattempted'],
        datasets: [{
            label: 'Question Count',
            data: [<?= $correct ?>, <?= $wrong ?>, <?= $total_attempted ?>, <?= $unattempted ?>],
            backgroundColor: [
                'rgba(6, 214, 160, 0.7)',
                'rgba(239, 71, 111, 0.7)',
                'rgba(67, 97, 238, 0.7)',
                'rgba(173, 181, 189, 0.7)'
            ],
            borderColor: [
                'rgba(6, 214, 160, 1)',
                'rgba(239, 71, 111, 1)',
                'rgba(67, 97, 238, 1)',
                'rgba(173, 181, 189, 1)'
            ],
            borderWidth: 1,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                titleFont: {
                    family: "'Poppins', sans-serif"
                },
                bodyFont: {
                    family: "'Poppins', sans-serif"
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    font: {
                        family: "'Poppins', sans-serif"
                    },
                    stepSize: 1
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                ticks: {
                    font: {
                        family: "'Poppins', sans-serif",
                        size: 13
                    }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});

// Action Button Functions
function retakeExam() {
    if(confirm('Do you want to retake this exam?')) {
        // Redirect to exam page with same parameters
        window.location.href = `mock_test.php?sid=<?= $sid ?>&setid=<?= $setid ?>`;
    }
}

function reviewAnswers() {
    // Scroll to the detailed summary section
    document.querySelector('.detailed-summary').scrollIntoView({
        behavior: 'smooth'
    });
}

function goToDashboard() {
    window.location.href = 'dashboard.php';
}

// Print result
function printResult() {
    window.print();
}

// Add print button event listener if needed
document.addEventListener('keydown', function(e) {
    if(e.ctrlKey && e.key === 'p') {
        e.preventDefault();
        printResult();
    }
});

// Add animation on scroll
const observerOptions = {
    threshold: 0.1
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if(entry.isIntersecting) {
            entry.target.style.opacity = 1;
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all cards for animation
document.querySelectorAll('.card, .score-card').forEach(card => {
    card.style.opacity = 0;
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    observer.observe(card);
});
</script>

</body>
</html>