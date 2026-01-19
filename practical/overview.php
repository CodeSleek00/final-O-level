<?php
include("../db_connect.php");
$subjects = $conn->query("SELECT DISTINCT subject FROM practical_questions ORDER BY subject");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Practical Subjects</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: #fafbfc;
    color: #1f2937;
    line-height: 1.5;
    padding: 20px;
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
}

/* Header */
.header {
    text-align: center;
    margin-bottom: 40px;
    padding-top: 10px;
}

.header h1 {
    font-size: 28px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 8px;
}

.header p {
    color: #6b7280;
    font-size: 15px;
}

/* Grid */
.subjects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

/* Card */
.subject-card {
    background: white;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    transition: all 0.2s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.subject-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.08);
    transform: translateY(-2px);
}

.card-header {
    background: #2563eb;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.card-header span {
    color: white;
    font-size: 20px;
    font-weight: 500;
    text-align: center;
    line-height: 1.3;
}

.card-body {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.card-body p {
    color: #6b7280;
    font-size: 14px;
    margin-bottom: 20px;
    flex-grow: 1;
}

/* Button */
.btn {
    display: block;
    padding: 10px 16px;
    background: #2563eb;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    text-align: center;
    transition: background 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn:hover {
    background: #1d4ed8;
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
}

.empty-state h3 {
    font-size: 18px;
    color: #111827;
    margin-bottom: 8px;
}

.empty-state p {
    color: #6b7280;
    max-width: 400px;
    margin: 0 auto;
}

/* Footer */
.footer {
    text-align: center;
    padding: 20px 0;
    color: #9ca3af;
    font-size: 13px;
    border-top: 1px solid #e5e7eb;
    margin-top: 40px;
}

/* Responsive */
@media (max-width: 768px) {
    .subjects-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .header h1 {
        font-size: 24px;
    }
}

@media (max-width: 576px) {
    .subjects-grid {
        grid-template-columns: 1fr;
    }
    
    body {
        padding: 15px;
    }
    
    .header {
        margin-bottom: 30px;
    }
}
</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Practical Subjects</h1>
            <p>Browse chapter-wise practical questions</p>
        </div>
        
        <div class="subjects-grid">
            <?php if ($subjects->num_rows > 0): ?>
                <?php while($row = $subjects->fetch_assoc()): ?>
                <div class="subject-card">
                    <div class="card-header">
                        <span><?= htmlspecialchars($row['subject']) ?></span>
                    </div>
                    
                    <div class="card-body">
                        <p>Chapter wise practical questions for <?= htmlspecialchars($row['subject']) ?></p>
                        <a class="btn" href="subject_questions.php?subject=<?= urlencode($row['subject']) ?>">
                            Open Subject
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <h3>No Subjects Available</h3>
                    <p>There are currently no practical subjects in the database.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="footer">
            <p>Practical Subjects Portal • <?= date('Y') ?></p>
        </div>
    </div>
</body>
</html>