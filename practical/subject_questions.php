<?php
include("../db_connect.php");

$subject = $_GET['subject'] ?? '';
if(!$subject){
    echo "Invalid Subject"; exit;
}

$questions = $conn->query("SELECT * FROM practical_questions WHERE subject='{$subject}' ORDER BY chapter, id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($subject) ?> - Questions</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: #fafafa;
    color: #333;
    line-height: 1.6;
    padding: 0;
    
}

/* Header */
.header {
    position: sticky;
    top: 0;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 20px 24px;
    border-bottom: 1px solid #eee;
    z-index: 100;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #666;
    text-decoration: none;
    font-size: 15px;
    font-weight: 400;
    padding: 8px 0;
    transition: color 0.2s;
}

.back-btn:hover {
    color: #2563eb;
}

.subject-title {
    margin-top: 8px;
    font-size: 22px;
    font-weight: 600;
    color: #111;
}

/* Main Content */
.content {
    padding: 24px;
}

.chapter-section {
    margin-bottom: 32px;
}

.chapter-header {
    font-size: 17px;
    font-weight: 500;
    color: #2563eb;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #e8f0fe;
    display: flex;
    align-items: center;
    gap: 10px;
}

.chapter-header::before {
    content: "📚";
    font-size: 16px;
}

/* Questions List */
.questions-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.question-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 18px 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    color: inherit;
    display: block;
}

.question-card:hover {
    border-color: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
}

.question-text {
    font-size: 15px;
    font-weight: 400;
    color: #374151;
    margin-bottom: 8px;
    line-height: 1.5;
}

.question-meta {
    font-size: 13px;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 8px;
}

.question-meta::before {
    content: "→";
    color: #2563eb;
    font-weight: 500;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-text {
    font-size: 16px;
    font-weight: 400;
}

/* Mobile Responsive */
@media (max-width: 640px) {
    body {
        background: white;
    }
    
    .header {
        padding: 16px 20px;
        background: white;
    }
    
    .content {
        padding: 20px;
    }
    
    .subject-title {
        font-size: 20px;
    }
    
    .chapter-header {
        font-size: 16px;
        margin-bottom: 14px;
    }
    
    .question-card {
        padding: 16px;
        border-radius: 10px;
    }
    
    .question-text {
        font-size: 14.5px;
    }
    
    .question-card:active {
        transform: scale(0.99);
        background: #f8fafc;
    }
}

/* Tablet */
@media (min-width: 641px) and (max-width: 1024px) {
    body {
        padding: 0 20px;
    }
    
    .header {
        border-radius: 0 0 12px 12px;
        margin-bottom: 8px;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.question-card {
    animation: fadeIn 0.3s ease-out;
}

.chapter-section {
    animation: fadeIn 0.4s ease-out;
}

/* Focus States for Accessibility */
.question-card:focus-visible {
    outline: 2px solid #2563eb;
    outline-offset: 2px;
}

.back-btn:focus-visible {
    outline: 2px solid #2563eb;
    border-radius: 4px;
    padding: 4px 8px;
}
</style>
</head>
<body>

<header class="header">
    <a href="overview_subjects.php" class="back-btn">
        ← Back to Subjects
    </a>
    <h1 class="subject-title"><?= htmlspecialchars($subject) ?></h1>
</header>

<main class="content">
    <?php
    $currentChapter = '';
    $hasQuestions = false;
    
    if($questions->num_rows > 0):
        while($q = $questions->fetch_assoc()):
            $hasQuestions = true;
            
            if($currentChapter !== $q['chapter']):
                if($currentChapter !== ''):
                    echo '</div>'; // Close previous questions-list
                endif;
                
                $currentChapter = $q['chapter'];
                echo "<div class='chapter-section'>";
                echo "<div class='chapter-header'>" . htmlspecialchars($currentChapter) . "</div>";
                echo "<div class='questions-list'>";
            endif;
    ?>
            <a href="answer.php?id=<?= $q['id'] ?>" class="question-card">
                <div class="question-text">
                    <?= htmlspecialchars($q['question']) ?>
                </div>
                <div class="question-meta">
                    View Answer
                </div>
            </a>
    <?php
        endwhile;
        
        if($hasQuestions):
            echo '</div></div>'; // Close last chapter-section
        endif;
    else:
    ?>
    <div class="empty-state">
        <div class="empty-icon">📝</div>
        <div class="empty-text">No questions found for this subject</div>
    </div>
    <?php endif; ?>
</main>

<script>
// Add smooth scrolling for better UX
document.addEventListener('DOMContentLoaded', function() {
    // Add subtle animation to cards on load
    const cards = document.querySelectorAll('.question-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.05}s`;
    });
    
    // Mobile touch feedback
    if ('ontouchstart' in window) {
        const cards = document.querySelectorAll('.question-card');
        cards.forEach(card => {
            card.addEventListener('touchstart', function() {
                this.style.transition = 'transform 0.1s, background 0.1s';
            });
            
            card.addEventListener('touchend', function() {
                this.style.transition = 'all 0.2s ease';
            });
        });
    }
});
</script>

</body>
</html>