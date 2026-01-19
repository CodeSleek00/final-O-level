<?php
include("../db_connect.php");
$subjects = $conn->query("SELECT DISTINCT subject FROM practical_questions ORDER BY subject");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Subjects</title>
<link rel="icon" type="image/png" href="../image/olevel.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
* {
    box-sizing: border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:#f8fafc;
    
    margin:0;
    min-height: 100vh;
    -webkit-tap-highlight-color: transparent;
}

/* PAGE TITLE */
h2{
    text-align:center;
    margin-bottom:25px;
    font-size:22px;
    font-weight:600;
    color:#0f172a;
    padding: 0 10px;
}

/* GRID */
.subject-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:18px;
    max-width:1000px;
    margin:auto;
}

/* CARD */
.subject-card{
    background:white;
    border-radius:14px;
    padding:20px;
    border:1px solid #e5e7eb;
    transition:0.25s;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* DESKTOP HOVER */
@media (hover:hover){
    .subject-card:hover{
        border-color:#2563eb;
        box-shadow:0 8px 20px rgba(37,99,235,0.12);
        transform:translateY(-4px);
    }
}

/* TITLE */
.subject-title{
    font-size:17px;
    font-weight:600;
    color:#0f172a;
    margin-bottom:6px;
    line-height: 1.4;
}

/* SUBTEXT */
.subject-meta{
    font-size:14px;
    color:#64748b;
    margin-bottom:14px;
    line-height: 1.5;
}

/* BUTTON */
.btn{
    display:inline-block;
    padding:9px 16px;
    font-size:14px;
    border-radius:8px;
    text-decoration:none;
    border:1px solid #2563eb;
    color:#2563eb;
    transition:0.2s;
    text-align: center;
    font-weight: 500;
    cursor: pointer;
    -webkit-user-select: none;
    user-select: none;
}

/* DESKTOP HOVER */
@media (hover:hover){
    .btn:hover{
        background:#2563eb;
        color:white;
    }
}

/* ---------- MOBILE UI ---------- */
@media(max-width:640px){
    body {
        padding: 15px;
    }

    h2{
        font-size:20px;
        margin-bottom:20px;
    }

    .subject-grid{
        grid-template-columns:1fr;
        gap:14px;
    }

    .subject-card{
        padding:18px;
        border-radius: 12px;
        margin-bottom: 4px;
    }

    .subject-title{
        font-size:16px;
        margin-bottom: 8px;
    }

    .subject-meta{
        font-size:13px;
        margin-bottom: 16px;
    }

    .btn{
        width:100%;
        text-align:center;
        padding:12px;
        font-size:15px;
        border-radius:10px;
        display: block;
    }

    /* Mobile touch feedback */
    .subject-card:active {
        background-color: #f8fafc;
        transform: scale(0.98);
        transition: transform 0.1s;
    }

    .btn:active {
        background: #2563eb;
        color: white;
        transform: scale(0.98);
    }

    /* For iOS Safari */
    @supports (-webkit-touch-callout: none) {
        .subject-card {
            -webkit-tap-highlight-color: rgba(0,0,0,0.1);
        }
    }
}

/* Tablet responsive */
@media (min-width: 641px) and (max-width: 768px) {
    .subject-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        padding: 0 10px;
    }

    h2 {
        padding: 0 20px;
    }
}

/* Empty state */
.subject-grid:empty::before {
    content: "No subjects available";
    text-align: center;
    grid-column: 1/-1;
    color: #64748b;
    padding: 40px;
    font-size: 16px;
}

/* Loading animation for card (if needed) */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.subject-card {
    animation: fadeIn 0.3s ease-out;
}

/* Better focus styles for accessibility */
.btn:focus-visible {
    outline: 2px solid #2563eb;
    outline-offset: 2px;
    background: #2563eb;
    color: white;
}

.subject-card:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}
   /* ===== BANNER ===== */
        .it-banner {
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
            margin: 20px;
        }
        
</style>
</head>
<body>
<?php include 'navbar.html'; ?>
  <section class="it-banner">
        <h1>Practicals</h1>
        <p>
            Practice updated Practical on the latest NIELIT syllabus.
            Improve accuracy, speed, and confidence with topic-wise
            practicals designed for O Level students.
        </p>
    </section>
<div class="subject-grid">

<?php 
if ($subjects->num_rows > 0) {
    while($row = $subjects->fetch_assoc()): 
?>
<div class="subject-card">
    <div>
        <div class="subject-title"><?= htmlspecialchars($row['subject']) ?></div>
        <div class="subject-meta">Chapter-wise practical questions</div>
    </div>
    <a class="btn" href="subject_questions.php?subject=<?= urlencode($row['subject']) ?>">
        View Questions →
    </a>
</div>
<?php 
    endwhile;
} else {
    echo '<div style="text-align:center; grid-column:1/-1; padding:40px; color:#64748b;">No subjects found</div>';
}
?>

</div>

<script>
// Mobile touch improvements
document.addEventListener('DOMContentLoaded', function() {
    // Add touch feedback for mobile
    if ('ontouchstart' in window) {
        const cards = document.querySelectorAll('.subject-card');
        const buttons = document.querySelectorAll('.btn');
        
        cards.forEach(card => {
            card.addEventListener('touchstart', function() {
                this.style.transition = 'transform 0.1s';
            });
            
            card.addEventListener('touchend', function() {
                this.style.transition = '0.25s';
            });
        });
        
        buttons.forEach(btn => {
            btn.addEventListener('touchstart', function() {
                this.style.transition = 'all 0.1s';
            });
            
            btn.addEventListener('touchend', function() {
                this.style.transition = '0.2s';
            });
        });
    }
    
    // Prevent long-tap text selection on mobile
    document.addEventListener('contextmenu', function(e) {
        if (window.innerWidth <= 640) {
            e.preventDefault();
        }
    });
});
</script>

</body>
</html>