<?php
include("../db_connect.php");

if(!isset($_GET['id'])){
    die("Invalid Request");
}

$id = intval($_GET['id']);
$q = $conn->query("SELECT * FROM practical_questions WHERE id=$id");
$data = $q->fetch_assoc();

if(!$data){
    die("Question not found");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>O Level Practical Question</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --primary-blue: #2563eb;
    --primary-blue-light: #dbeafe;
    --light-bg: #f4f6f9;
    --card-bg: #ffffff;
    --text-dark: #1e293b;
    --text-light: #64748b;
    --border-color: #e5e7eb;
    --success-green: #10b981;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
    --shadow-md: 0 4px 12px rgba(0,0,0,0.05);
    --shadow-lg: 0 10px 25px rgba(0,0,0,0.05);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: var(--light-bg);
    color: var(--text-dark);
    line-height: 1.6;
    padding: 0;
}

/* Header */
.header {
    background: var(--card-bg);
    padding: 18px 0;
    border-bottom: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    position: sticky;
    top: 0;
    z-index: 100;
}

.header-content {
    max-width: 900px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
}

.header-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--primary-blue);
    display: flex;
    align-items: center;
    gap: 10px;
}

.header-title i {
    font-size: 1.2rem;
}

/* Container */
.container {
    max-width: 900px;
    margin: 30px auto;
    padding: 0 20px;
}

/* Card */
.card {
    background: var(--card-bg);
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    border: 1px solid var(--border-color);
    margin-bottom: 30px;
}

.card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    padding: 24px 30px;
    border-bottom: 1px solid var(--border-color);
}

.question-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    flex-wrap: wrap;
    gap: 15px;
}

.question-id {
    display: inline-flex;
    align-items: center;
    background: var(--primary-blue-light);
    color: var(--primary-blue);
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
}

.question-type {
    display: inline-flex;
    align-items: center;
    background: #f0f9ff;
    color: #0369a1;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
}

.question-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    line-height: 1.4;
}

/* Card Body */
.card-body {
    padding: 30px;
}

/* Question Content */
.question-content {
    margin-bottom: 32px;
}

.question-text {
    font-size: 1.1rem;
    font-weight: 500;
    color: var(--text-dark);
    line-height: 1.7;
    margin-bottom: 20px;
}

.question-text::before {
    content: "📌 ";
}

/* Question Image */
.question-image-container {
    margin: 24px 0;
    text-align: center;
}

.question-image {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
}

.image-caption {
    font-size: 0.85rem;
    color: var(--text-light);
    margin-top: 8px;
    font-style: italic;
}

/* Answer Section */
.answer-section {
    background: #f9fafb;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.answer-header {
    background: linear-gradient(135deg, var(--primary-blue) 0%, #1d4ed8 100%);
    color: white;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.answer-title {
    font-size: 1.2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
}

.answer-content {
    padding: 24px;
    font-size: 1rem;
    line-height: 1.8;
    white-space: pre-wrap;
}

.answer-content pre {
    background: #f1f5f9;
    padding: 18px;
    border-radius: 8px;
    overflow-x: auto;
    margin: 15px 0;
    font-family: 'Courier New', monospace;
    font-size: 0.95rem;
}

/* Back Button */
.back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--card-bg);
    color: var(--primary-blue);
    text-decoration: none;
    padding: 12px 22px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
}

.back-button:hover {
    background: var(--primary-blue);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Footer */
.footer {
    text-align: center;
    padding: 20px;
    color: var(--text-light);
    font-size: 0.9rem;
    border-top: 1px solid var(--border-color);
    margin-top: 30px;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 0 15px;
    }
    
    .card-header, .card-body {
        padding: 20px;
    }
    
    .question-title {
        font-size: 1.3rem;
    }
    
    .question-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .header-title {
        font-size: 1.2rem;
    }
}

@media (max-width: 480px) {
    .question-title {
        font-size: 1.2rem;
    }
    
    .answer-header {
        padding: 14px 18px;
    }
    
    .answer-content {
        padding: 18px;
    }
}
</style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">

            <a href="python_practicals.php" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Questions
            </a>
        </div>
    </header>

    <!-- Main Container -->
    <div class="container">
        <!-- Question Card -->
        <div class="card">
            <!-- Card Header -->
            <div class="card-header">
                <div class="question-meta">
                    <span class="question-id">
                        <i class="fas fa-hashtag"></i>
                        Question ID: <?= $id ?>
                    </span>
                    <span class="question-type">
                        <i class="fas fa-code"></i>
                        Python Programming
                    </span>
                </div>
                <h1 class="question-title">Practical Question</h1>
            </div>
            
            <!-- Card Body -->
            <div class="card-body">
                <!-- Question Content -->
                <div class="question-content">
                    <div class="question-text">
                        <?= htmlspecialchars($data['question']) ?>
                    </div>
                    
                    <!-- Question Image -->
                    <?php if(!empty($data['image'])): ?>
                    <div class="question-image-container">
                        <img src="../admin/uploads/<?= htmlspecialchars($data['image']) ?>" 
                             alt="Question Illustration" 
                             class="question-image">
                        <div class="image-caption">Question Diagram</div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Answer Section -->
                <div class="answer-section">
                    <div class="answer-header">
                        <div class="answer-title">
                            <i class="fas fa-lightbulb"></i>
                            Solution & Explanation
                        </div>
                        <span class="answer-badge">
                            <i class="fas fa-check-circle"></i>
                            Verified Answer by Faiz Computer Institute
                        </span>
                    </div>
                    <div class="answer-content">
                        <?php 
                        // Format code if it appears in the answer
                        $answer = htmlspecialchars($data['answer']);
                        // Simple formatting for code blocks (if they exist)
                        $answer = preg_replace('/```(.*?)```/s', '<pre>$1</pre>', $answer);
                        echo $answer;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>O Level Computer Science Practical Questions &copy; <?= date('Y') ?></p>
    </footer>

    <script>
        // Simple script to enhance code blocks
        document.addEventListener('DOMContentLoaded', function() {
            // Add line numbers to code blocks
            const codeBlocks = document.querySelectorAll('pre');
            codeBlocks.forEach(block => {
                const lines = block.textContent.split('\n').length;
                if(lines > 1) {
                    block.style.position = 'relative';
                    block.style.paddingLeft = '3.5em';
                    
                    // Create line numbers
                    let lineNumbers = '';
                    for(let i = 1; i <= lines; i++) {
                        lineNumbers += i + '<br>';
                    }
                    
                    const lineNumbersDiv = document.createElement('div');
                    lineNumbersDiv.innerHTML = lineNumbers;
                    lineNumbersDiv.style.position = 'absolute';
                    lineNumbersDiv.style.left = '0';
                    lineNumbersDiv.style.top = '0';
                    lineNumbersDiv.style.padding = '18px 8px';
                    lineNumbersDiv.style.backgroundColor = '#e2e8f0';
                    lineNumbersDiv.style.color = '#64748b';
                    lineNumbersDiv.style.fontSize = '0.9rem';
                    lineNumbersDiv.style.borderRadius = '8px 0 0 8px';
                    lineNumbersDiv.style.textAlign = 'right';
                    lineNumbersDiv.style.lineHeight = '1.5';
                    
                    block.prepend(lineNumbersDiv);
                }
            });
            
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if(targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if(targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>