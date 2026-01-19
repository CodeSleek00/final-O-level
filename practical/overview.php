<?php
include("../db_connect.php");
$subjects = $conn->query("SELECT DISTINCT subject FROM practical_questions ORDER BY subject");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Practical Subjects - Browse by Subject</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --primary-blue: #2563eb;
    --blue-light: #60a5fa;
    --blue-ultralight: #eff6ff;
    --neutral-white: #ffffff;
    --neutral-gray-light: #f8fafc;
    --neutral-gray-medium: #e2e8f0;
    --neutral-gray-dark: #64748b;
    --neutral-gray-darker: #334155;
    --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.1);
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--neutral-gray-light);
    color: var(--neutral-gray-darker);
    line-height: 1.6;
    padding: 20px;
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* HEADER */
header {
    text-align: center;
    margin-bottom: 50px;
    padding-top: 20px;
}

.header-content {
    max-width: 800px;
    margin: 0 auto;
}

h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--neutral-gray-darker);
    margin-bottom: 12px;
    background: linear-gradient(135deg, var(--primary-blue), #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.subtitle {
    font-size: 1.1rem;
    color: var(--neutral-gray-dark);
    margin-bottom: 30px;
    font-weight: 400;
}

.subject-count {
    display: inline-block;
    background-color: var(--blue-ultralight);
    color: var(--primary-blue);
    padding: 8px 18px;
    border-radius: 50px;
    font-weight: 500;
    font-size: 0.95rem;
    border: 1px solid rgba(37, 99, 235, 0.2);
}

/* GRID LAYOUT */
.subject-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 28px;
    margin-bottom: 60px;
}

/* CARD */
.subject-card {
    background-color: var(--neutral-white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition);
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid var(--neutral-gray-medium);
    position: relative;
}

.subject-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
    border-color: var(--blue-light);
}

.subject-card:focus-within {
    outline: 3px solid rgba(37, 99, 235, 0.4);
    outline-offset: 2px;
}

/* CARD HEADER (FAKE IMAGE AREA) */
.card-header {
    height: 160px;
    background: linear-gradient(135deg, var(--primary-blue), var(--blue-light));
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    padding: 20px;
}

.card-header::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.15) 0%, transparent 20%),
        radial-gradient(circle at 90% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 20%);
}

.card-header span {
    font-size: 1.8rem;
    font-weight: 600;
    color: white;
    z-index: 2;
    text-align: center;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    line-height: 1.3;
}

/* CARD BODY */
.card-body {
    padding: 24px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.card-description {
    font-size: 0.95rem;
    color: var(--neutral-gray-dark);
    margin-bottom: 20px;
    flex-grow: 1;
}

/* BUTTON */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    background-color: var(--primary-blue);
    color: white;
    border-radius: var(--radius-md);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    transition: var(--transition);
    border: 2px solid transparent;
    cursor: pointer;
    width: 100%;
    text-align: center;
}

.btn:hover, .btn:focus {
    background-color: #1d4ed8;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(37, 99, 235, 0.2);
}

.btn:focus {
    outline: 3px solid rgba(37, 99, 235, 0.4);
    outline-offset: 2px;
}

.btn-icon {
    font-size: 0.9rem;
    transition: transform 0.3s ease;
}

.btn:hover .btn-icon {
    transform: translateX(4px);
}

/* EMPTY STATE */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background-color: var(--neutral-white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    border: 1px dashed var(--neutral-gray-medium);
}

.empty-state i {
    font-size: 3rem;
    color: var(--neutral-gray-medium);
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 1.5rem;
    color: var(--neutral-gray-darker);
    margin-bottom: 10px;
}

.empty-state p {
    color: var(--neutral-gray-dark);
    max-width: 500px;
    margin: 0 auto;
}

/* FOOTER */
footer {
    text-align: center;
    padding: 30px 0;
    color: var(--neutral-gray-dark);
    font-size: 0.9rem;
    border-top: 1px solid var(--neutral-gray-medium);
    margin-top: 30px;
}

/* RESPONSIVE DESIGN */
@media (max-width: 1100px) {
    .subject-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }
}

@media (max-width: 768px) {
    body {
        padding: 15px;
    }
    
    .container {
        padding: 0 15px;
    }
    
    h1 {
        font-size: 2rem;
    }
    
    .subtitle {
        font-size: 1rem;
    }
    
    .subject-grid {
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }
    
    .card-header {
        height: 140px;
    }
    
    .card-header span {
        font-size: 1.6rem;
    }
}

@media (max-width: 576px) {
    .subject-grid {
        grid-template-columns: 1fr;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }
    
    h1 {
        font-size: 1.8rem;
    }
    
    header {
        margin-bottom: 40px;
    }
}

/* ACCESSIBILITY IMPROVEMENTS */
.visually-hidden {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

/* FOCUS VISIBLE FOR KEYBOARD NAVIGATION */
*:focus-visible {
    outline: 3px solid rgba(37, 99, 235, 0.5);
    outline-offset: 2px;
}

/* REDUCED MOTION PREFERENCE */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
    
    .subject-card:hover {
        transform: none;
    }
    
    .btn:hover {
        transform: none;
    }
}

/* DARK MODE SUPPORT (optional) */
@media (prefers-color-scheme: dark) {
    :root {
        --neutral-white: #1e293b;
        --neutral-gray-light: #0f172a;
        --neutral-gray-medium: #334155;
        --neutral-gray-dark: #cbd5e1;
        --neutral-gray-darker: #f1f5f9;
        --blue-ultralight: rgba(37, 99, 235, 0.15);
    }
    
    .subject-card {
        border-color: var(--neutral-gray-medium);
    }
    
    .empty-state {
        border-color: var(--neutral-gray-medium);
    }
}
</style>
</head>
<body>
    <div class="container">
        <header>
            <div class="header-content">
                <h1>Practical Subjects</h1>
                <p class="subtitle">Browse chapter-wise practical questions for each subject</p>
                <div class="subject-count">
                    <i class="fas fa-book-open"></i>
                    <?php 
                    $count = $subjects->num_rows;
                    echo htmlspecialchars($count) . " Subject" . ($count !== 1 ? 's' : '');
                    ?>
                </div>
            </div>
        </header>
        
        <main>
            <div class="subject-grid">
                <?php 
                // Reset pointer to beginning after counting rows
                $subjects->data_seek(0);
                
                if ($subjects->num_rows > 0): 
                    while($row = $subjects->fetch_assoc()): 
                        $subjectName = htmlspecialchars($row['subject']);
                        $shortSubject = strlen($subjectName) > 25 ? substr($subjectName, 0, 22) . '...' : $subjectName;
                ?>
                <div class="subject-card" tabindex="0">
                    <div class="card-header">
                        <span><?= $shortSubject ?></span>
                    </div>
                    
                    <div class="card-body">
                        <p class="card-description">
                            Access chapter-wise practical questions and exercises for <?= htmlspecialchars($row['subject']) ?>.
                        </p>
                        
                        <a class="btn" href="subject_questions.php?subject=<?= urlencode($row['subject']) ?>" aria-label="Open practical questions for <?= htmlspecialchars($row['subject']) ?>">
                            <span>Open Subject</span>
                            <i class="fas fa-arrow-right btn-icon" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
                
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h3>No Subjects Found</h3>
                    <p>There are currently no practical subjects available in the database. Please check back later.</p>
                </div>
                <?php endif; ?>
            </div>
        </main>
        
        <footer>
            <p>Practical Subjects Portal &copy; <?= date('Y') ?> | Accessible & Responsive Design</p>
        </footer>
    </div>

    <script>
    // Enhance keyboard navigation
    document.addEventListener('DOMContentLoaded', function() {
        // Make entire card clickable on Enter key when focused
        const cards = document.querySelectorAll('.subject-card');
        
        cards.forEach(card => {
            card.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const link = this.querySelector('.btn');
                    if (link) link.click();
                }
            });
            
            // Improve screen reader announcement
            card.setAttribute('role', 'article');
            card.setAttribute('aria-labelledby', 'subject-title');
        });
        
        // Add loading animation for cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px 50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Apply initial styles for animation
        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });
    });
    </script>
</body>
</html>