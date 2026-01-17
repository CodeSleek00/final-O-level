<?php
include '../db_connect.php';

// Get selected subject from URL (if any)
$selected_subject_id = isset($_GET['subject']) ? intval($_GET['subject']) : 0;

// Fetch selected subject info
$subject = $conn->query("SELECT * FROM subjects WHERE id = $selected_subject_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chapter-wise Practice</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body { font-family:'Poppins',sans-serif; background:#f4f6f9; margin:0; padding:0; }
.page-wrapper { max-width:900px; margin:50px auto; padding:20px; }
h1 { color:#1e40af; font-size:2rem; margin-bottom:10px; text-align:center; }
.subtitle { text-align:center; color:#555; font-size:1rem; margin-bottom:30px; }

/* Subject filter buttons */
.subject-filters { text-align:center; margin-bottom:30px; }
.subject-filters a {
    display:inline-block;
    margin:5px 10px;
    padding:10px 25px;
    background:#4f46e5;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-weight:500;
    transition:0.3s;
}
.subject-filters a.active, .subject-filters a:hover { background:#6366f1; }

/* Chapter table */
.chapter-table { width:100%; border-collapse:collapse; }
.chapter-table tr { border-bottom:1px solid #eee; transition:0.2s; }
.chapter-table tr:hover { background:#f0f4ff; }
.chapter-table td { padding:15px; vertical-align:middle; }
.chapter-name { font-weight:500; font-size:16px; color:#1e40af; }
.start-btn { background:#4f46e5; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:500; transition:0.3s; display:inline-block; }
.start-btn:hover { background:#6366f1; }
@media (max-width:600px){
    .chapter-table td { display:block; width:100%; padding:10px 0; text-align:center; }
    .start-btn { width:80%; margin-top:5px; }
}
</style>
</head>
<body>

<div class="page-wrapper">

<h1>Chapter-wise MCQ Practice</h1>
<div class="subtitle">Select a subject and practice chapters</div>

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
        echo '<table class="chapter-table">';
        while($ch = $chapters->fetch_assoc()){
            echo '<tr>
                    <td class="chapter-name">'.htmlspecialchars($ch['chapter_name']).' ('.$ch['total_questions'].' Qs)</td>
                    <td style="text-align:right;"><a class="start-btn" href="chapter_exam.php?chapter_id='.$ch['id'].'">Start Exam</a></td>
                  </tr>';
        }
        echo '</table>';
    } else {
        echo '<p style="text-align:center; margin-top:30px;">No chapters with questions found for this subject.</p>';
    }
} else {
    echo '<p style="text-align:center; margin-top:30px;">Select a subject to view chapters.</p>';
}
?>

</div>
</body>
</html>
