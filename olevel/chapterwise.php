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
<title>Chapter-wise MCQ Practice</title>

<!-- Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Custom CSS -->
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

<style>
body { font-family: 'Poppins', sans-serif; background: #f9f9f9; margin: 0; }
.page-wrapper { max-width: 1200px; margin: 0 auto; padding: 20px; }

.it-banner { text-align: center; padding: 40px 20px 20px; }
.it-banner h1 { color: #1e40af; font-size: 2.5rem; margin-bottom: 10px; }
.it-banner p { color: #555; font-size: 1.1rem; }

.subject-filters { text-align: center; margin-bottom: 30px; }
.subject-filters a {
    display: inline-block;
    margin: 0 10px;
    padding: 10px 25px;
    background: #4f46e5;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    transition: 0.3s;
}
.subject-filters a.active,
.subject-filters a:hover { background: #6366f1; }

.subject-banner {
    background: linear-gradient(90deg, #4f46e5, #6366f1);
    color: #fff;
    padding: 25px 20px;
    margin: 20px 0;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.subject-banner h2 { font-size: 1.8rem; }

.container h3 { font-size: 1.5rem; color: #1e3a8a; margin-bottom: 15px; }
.cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
.chapter-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.05);
    text-align: center;
    transition: 0.3s;
}
.chapter-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
.chapter-card h4 { font-size: 1.3rem; color: #1e40af; margin-bottom: 10px; }
.chapter-card p { font-size: 1rem; margin-bottom: 15px; }
.start-btn { display: inline-block; background: #4f46e5; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 500; transition: 0.3s; }
.start-btn:hover { background: #6366f1; }
</style>
</head>
<body>

<?php include 'navbar.html'; ?>

<div class="page-wrapper">

    <!-- Main Banner -->
    <div class="it-banner">
        <h1>Chapter-wise MCQ Practice</h1>
        <p>Select a subject and practice chapter-wise questions</p>
    </div>

    <!-- Subject Filters -->
    <div class="subject-filters">
    <?php
    $all_subjects = $conn->query("SELECT * FROM subjects ORDER BY id ASC");
    if($all_subjects && $all_subjects->num_rows > 0){
        while($sub = $all_subjects->fetch_assoc()){
            $active = ($selected_subject_id === intval($sub['id'])) ? 'active' : '';
            echo '<a class="'.$active.'" href="?subject='.$sub['id'].'">'.htmlspecialchars($sub['subject_name']).'</a>';
        }
    }
    ?>
    </div>

<?php
if($selected_subject_id > 0){
    // Fetch chapters for selected subject
    $chapters = $conn->query("SELECT * FROM chapters WHERE subject_id = $selected_subject_id ORDER BY id ASC");
    
    if($chapters && $chapters->num_rows > 0){
        echo '<div class="container"><h3>Chapters</h3><div class="cards-grid">';
        while($chapter = $chapters->fetch_assoc()){
            $chapter_id = intval($chapter['id']);
            
            // Count total questions in this chapter
            $q_count = $conn->query("SELECT COUNT(*) AS total_questions FROM chapter_questions WHERE subject_id = $selected_subject_id AND chapter_id = $chapter_id");
            $q_row = $q_count->fetch_assoc();
?>
            <div class="chapter-card">
                <h4><?= htmlspecialchars($chapter['chapter_name']); ?></h4>
                <p>Total Questions: <b><?= $q_row['total_questions']; ?></b></p>
                <a class="start-btn" href="chapter_exam.php?sid=<?= $selected_subject_id; ?>&chapter_id=<?= $chapter_id; ?>">Start Chapter Exam</a>
            </div>
<?php
        }
        echo '</div></div>'; // end cards grid & container
    } else {
        echo "<p style='text-align:center;'>No chapters found for this subject.</p>";
    }
} else {
    echo "<p style='text-align:center;'>Select a subject to view chapters.</p>";
}
?>

</div>
</body>
</html>
