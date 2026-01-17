<?php
include '../db_connect.php';

// Get selected subject from URL (if any)
$selected_subject_id = isset($_GET['subject']) ? intval($_GET['subject']) : 0;

// Fetch selected subject info
$subject = $selected_subject_id > 0 ? 
    $conn->query("SELECT * FROM subjects WHERE id = $selected_subject_id")->fetch_assoc() : 
    null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chapter-wise Practice</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600&display=swap" rel="stylesheet">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* Minimal Reset */
* { margin: 0; padding: 0; box-sizing: border-box; }

/* Typography & Base */
body {
    font-family: 'Inter', sans-serif;
    background: #f8fafc;
    color: #334155;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
}

/* Page Wrapper */
.page-wrapper {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px 24px 60px;
}

/* Header Section */
.header-section {
     background: url('../image/bg.svg');
            background-size: cover;
            background-position: center center;
            padding: 40px 40px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            text-align: center;
            margin-bottom: 50px;
            background-color: black;
            color: white;
}

.header-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 16px;
    letter-spacing: -0.5px;
}

.header-subtitle {
    font-size: 1.1rem;
    color: #a5afbc;
    font-weight: 400;
    max-width: 550px;
    margin: 0 auto;
}

/* Subject Navigation */
.subject-nav {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 48px;
    padding: 10px 10px;
    z-index: 1;
}

.subject-nav-item {
    padding: 12px 24px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    color: #475569;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    cursor: pointer;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
}

.subject-nav-item:hover {
    border-color: #3b82f6;
    color: #3b82f6;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.08);
}

.subject-nav-item.active {
    background: #3b82f6;
    border-color: #3b82f6;
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
}

/* Subject Header */
.subject-header {
    margin: 40px 0 32px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
}

.subject-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 1.8rem;
    color: #0f172a;
    font-weight: 600;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.subject-title i {
    color: #3b82f6;
}

.subject-description {
    color: #64748b;
    font-size: 1rem;
}

/* Chapters List */
.chapters-list {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    border: 1px solid #f1f5f9;
}

.chapter-item {
    padding: 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.2s ease;
}

.chapter-item:hover {
    background: #f8fafc;
}

.chapter-item:last-child {
    border-bottom: none;
}

.chapter-info {
    display: flex;
    align-items: center;
    gap: 16px;
}

.chapter-icon {
    width: 44px;
    height: 44px;
    background: #eff6ff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #3b82f6;
    font-size: 1.2rem;
}

.chapter-details h3 {
    font-weight: 600;
    color: #0f172a;
    font-size: 1.1rem;
    margin-bottom: 4px;
}

.chapter-details .question-count {
    font-size: 0.9rem;
    color: #64748b;
    font-weight: 500;
}

.chapter-action {
    display: flex;
    align-items: center;
    gap: 16px;
}

.chapter-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: #3b82f6;
    color: white;
    padding: 10px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    white-space: nowrap;
}

.chapter-button:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}

.chapter-button i {
    font-size: 0.9rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: #f8fafc;
    border-radius: 16px;
    border: 1px dashed #cbd5e1;
    margin-top: 20px;
}

.empty-icon {
    font-size: 3.5rem;
    color: #cbd5e1;
    margin-bottom: 24px;
}

.empty-state h3 {
    color: #64748b;
    font-weight: 600;
    margin-bottom: 12px;
    font-size: 1.3rem;
}

.empty-state p {
    color: #94a3b8;
    max-width: 400px;
    margin: 0 auto;
}

/* Selection Prompt */
.selection-prompt {
    text-align: center;
    padding: 80px 20px;
    background: #f8fafc;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
}

.selection-icon {
    font-size: 3rem;
    color: #3b82f6;
    margin-bottom: 24px;
    opacity: 0.8;
}

.selection-prompt h3 {
    color: #475569;
    font-weight: 600;
    margin-bottom: 12px;
    font-size: 1.3rem;
}

.selection-prompt p {
    color: #94a3b8;
    max-width: 400px;
    margin: 0 auto;
}

/* Responsive */
@media (max-width: 768px) {
    .page-wrapper {
        padding: 0 16px 40px;
    }
    
    .header-title {
        font-size: 2rem;
    }
    
    .header-subtitle {
        font-size: 1rem;
    }
    
    .subject-nav {
        gap: 8px;
    }
    
    .subject-nav-item {
        padding: 10px 18px;
        font-size: 0.9rem;
    }
    
    .chapter-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        padding: 20px;
    }
    
    .chapter-info {
        width: 100%;
    }
    
    .chapter-action {
        width: 100%;
        justify-content: flex-end;
    }
    
    .chapter-button {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .header-section {
        padding: 40px 10px 30px;
    }
    
    .header-title {
        font-size: 1.8rem;
    }
    
    .chapter-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}
</style>
</head>
<body>
<?php include 'navbar.html'; ?>
<div class="page-wrapper">

    <!-- Header -->
    <header class="header-section">
        <h1 class="header-title">Chapter-wise Practice</h1>
        <p class="header-subtitle">Master each topic individually by practicing questions organized by chapters</p>
    </header>

    <!-- Subject Navigation -->
    <nav class="subject-nav">
        <?php
        // Add "Select Subject" option
        $all_active = ($selected_subject_id === 0) ? 'active' : '';
        echo '<a class="subject-nav-item '.$all_active.'" href="?subject=0">Select Subject</a>';
        
        // Fetch all subjects
        $all_subjects = $conn->query("SELECT * FROM subjects ORDER BY id ASC");
        if($all_subjects && $all_subjects->num_rows > 0){
            while($sub = $all_subjects->fetch_assoc()){
                $active = ($selected_subject_id === intval($sub['id'])) ? 'active' : '';
                echo '<a class="subject-nav-item '.$active.'" href="?subject='.$sub['id'].'">'.htmlspecialchars($sub['subject_name']).'</a>';
            }
        }
        ?>
    </nav>

<?php
if($selected_subject_id > 0 && $subject){
    // Subject header
    echo '<div class="subject-header">
            <h2 class="subject-title">
                <i class="fas fa-book-open"></i>
                '.htmlspecialchars($subject['subject_name']).' Chapters
            </h2>
            <p class="subject-description">Practice questions from each chapter separately</p>
          </div>';

    // Fetch chapters with at least 1 question
    $chapters = $conn->query("
        SELECT c.id, c.chapter_name, COUNT(q.id) AS total_questions
        FROM chapters c
        LEFT JOIN chapter_questions q ON c.id = q.chapter_id AND c.subject_id = q.subject_id
        WHERE c.subject_id = $selected_subject_id
        GROUP BY c.id
        HAVING total_questions > 0
        ORDER BY c.id ASC
    ");

    if($chapters && $chapters->num_rows > 0){
        echo '<div class="chapters-list">';
        $chapter_icons = ['fa-file-alt', 'fa-layer-group', 'fa-cube', 'fa-puzzle-piece', 'fa-code', 'fa-database', 'fa-network-wired', 'fa-shield-alt'];
        
        $index = 0;
        while($ch = $chapters->fetch_assoc()){
            $icon = $chapter_icons[$index % count($chapter_icons)];
            $index++;
            
            echo '<div class="chapter-item">
                    <div class="chapter-info">
                        <div class="chapter-icon">
                            <i class="fas '.$icon.'"></i>
                        </div>
                        <div class="chapter-details">
                            <h3>'.htmlspecialchars($ch['chapter_name']).'</h3>
                            <div class="question-count">'.$ch['total_questions'].' questions</div>
                        </div>
                    </div>
                    <div class="chapter-action">
                        <a class="chapter-button" href="chapter_exam.php?chapter_id='.$ch['id'].'&subject_id='.$selected_subject_id.'">
                            
                            Start Practice
                        </a>
                    </div>
                </div>';
        }
        echo '</div>';
    } else {
        // No chapters with questions
        echo '<div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-question"></i>
                </div>
                <h3>No Chapters Available</h3>
                <p>No chapters with practice questions found for this subject.</p>
              </div>';
    }
} else {
    // No subject selected
    echo '<div class="selection-prompt">
            <div class="selection-icon">
                <i class="fas fa-hand-pointer"></i>
            </div>
            <h3>Select a Subject</h3>
            <p>Choose a subject from the navigation above to view available chapters.</p>
          </div>';
}
?>

</div>

<script>
// Add animations on page load
document.addEventListener('DOMContentLoaded', function() {
    // Animate subject nav items
    const navItems = document.querySelectorAll('.subject-nav-item');
    navItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, 100 * index);
    });
    
    // Animate chapters
    const chapters = document.querySelectorAll('.chapter-item');
    chapters.forEach((chapter, index) => {
        chapter.style.opacity = '0';
        chapter.style.transform = 'translateX(-10px)';
        
        setTimeout(() => {
            chapter.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            chapter.style.opacity = '1';
            chapter.style.transform = 'translateX(0)';
        }, 150 * index);
    });
    
    // Add active state to clicked subject nav item
    const subjectNavItems = document.querySelectorAll('.subject-nav-item');
    subjectNavItems.forEach(item => {
        item.addEventListener('click', function() {
            subjectNavItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>
</body>
</html>