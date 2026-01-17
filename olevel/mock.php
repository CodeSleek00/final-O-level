<?php
include '../db_connect.php';

// Get selected subject from URL (if any)
$selected_subject_id = isset($_GET['subject']) ? intval($_GET['subject']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Subjects MCQ Practice</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600&display=swap" rel="stylesheet">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Custom CSS -->
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

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
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px 40px;
}

/* Header Section */
.header-section {
    text-align: center;
    padding: 60px 20px 40px;
    max-width: 800px;
    margin: 0 auto;
}

.header-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 2.8rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 16px;
    letter-spacing: -0.5px;
}

.header-subtitle {
    font-size: 1.15rem;
    color: #64748b;
    font-weight: 400;
    max-width: 600px;
    margin: 0 auto;
}

/* Subject Navigation */
.subject-nav {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 48px;
    padding: 0 10px;
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
}

.subject-description {
    color: #64748b;
    font-size: 1rem;
}

/* Tests Grid */
.tests-section {
    margin-bottom: 60px;
}

.section-title {
    font-size: 1.4rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: #3b82f6;
}

.tests-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

/* Test Card */
.test-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    border: 1px solid #f1f5f9;
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.test-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
    border-color: #e0f2fe;
}

.test-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.test-card-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #0f172a;
}

.test-card-badge {
    background: #eff6ff;
    color: #3b82f6;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.test-card-info {
    color: #64748b;
    font-size: 0.95rem;
    margin-bottom: 20px;
    flex-grow: 1;
}

.test-card-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: #3b82f6;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    width: 100%;
}

.test-card-button:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px dashed #cbd5e1;
}

.empty-icon {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #64748b;
    font-weight: 500;
    margin-bottom: 8px;
}

.empty-state p {
    color: #94a3b8;
}

/* Responsive */
@media (max-width: 768px) {
    .page-wrapper {
        padding: 0 16px 32px;
    }
    
    .header-title {
        font-size: 2.2rem;
    }
    
    .header-subtitle {
        font-size: 1.05rem;
    }
    
    .subject-nav {
        gap: 8px;
    }
    
    .subject-nav-item {
        padding: 10px 18px;
        font-size: 0.9rem;
    }
    
    .tests-grid {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body>

<?php include 'navbar.html'; ?>

<div class="page-wrapper">

    <!-- Header -->
   
        <div class="it-banner">
        <h1 class="header-title">MCQ Practice Hub</h1>
        <p class="header-subtitle">Practice questions across all subjects—Web, IoT, Python, IT Tools, and more—in one streamlined interface.</p>
</div>

    <!-- Subject Navigation -->
    <nav class="subject-nav">
        <?php
        // Add "All Subjects" option
        $all_active = ($selected_subject_id === 0) ? 'active' : '';
        echo '<a class="subject-nav-item '.$all_active.'" href="?subject=0">All Subjects</a>';
        
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
// If a subject is selected, show only that subject
if($selected_subject_id > 0){
    $subjects = $conn->query("SELECT * FROM subjects WHERE id = $selected_subject_id LIMIT 1");
} else {
    // If no subject selected, show all subjects
    $subjects = $conn->query("SELECT * FROM subjects ORDER BY id ASC");
}

if($subjects && $subjects->num_rows > 0){
    while($sub = $subjects->fetch_assoc()){
        $subject_id = intval($sub['id']);
?>

    <!-- Subject Section -->
    <section class="tests-section">
        <div class="subject-header">
            <h2 class="subject-title"><?= htmlspecialchars($sub['subject_name']); ?></h2>
            <p class="subject-description">Practice tests to master <?= htmlspecialchars($sub['subject_name']); ?> concepts</p>
        </div>

        <!-- Mock Tests -->
        <div class="section-title">
            <i class="fas fa-clipboard-list"></i>
            <span>Available Tests</span>
        </div>
        
        <div class="tests-grid">
        <?php
        $tests = $conn->query("
            SELECT set_id, COUNT(*) AS total_questions
            FROM questions
            WHERE subject_id = $subject_id
            GROUP BY set_id
            ORDER BY set_id ASC
        ");

        if($tests && $tests->num_rows > 0){
            while($row = $tests->fetch_assoc()){
        ?>
            <div class="test-card">
                <div class="test-card-header">
                    <h3 class="test-card-title">Test Set <?= $row['set_id']; ?></h3>
                    <span class="test-card-badge"><?= $row['total_questions']; ?> Qs</span>
                </div>
                <p class="test-card-info">Complete MCQ test covering key topics from <?= htmlspecialchars($sub['subject_name']); ?>.</p>
                <a class="test-card-button" href="../exam.php?sid=<?= $subject_id; ?>&setid=<?= $row['set_id']; ?>">
                    <i class="fas fa-play-circle"></i>
                    Start Test
                </a>
            </div>
        <?php 
            }
        } else {
            // Show empty state
            echo '<div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-clipboard-question"></i>
                    </div>
                    <h3>No Tests Available</h3>
                    <p>No practice tests have been added for this subject yet.</p>
                  </div>';
        }
        ?>
        </div>
    </section>

<?php 
    }
} else {
    // No subjects found
    echo '<div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <h3>No Subjects Found</h3>
            <p>No subjects have been added to the system yet.</p>
          </div>';
}
?>

</div>

<script>
// Add subtle animations on page load
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards on load
    const cards = document.querySelectorAll('.test-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 * index);
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