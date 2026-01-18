<?php
include "db_connect.php";

$sid   = intval($_GET['sid']);
$setid = intval($_GET['setid']);

// Fetch questions
$q = $conn->query("SELECT * FROM questions WHERE subject_id=$sid AND set_id=$setid");
$questions = [];
while($row = $q->fetch_assoc()){
    $questions[] = $row;
}
$total = count($questions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Mock Test</title>
<style>
body{font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:0;}
.container{display:flex; max-width:1000px; margin:20px auto; background:white; box-shadow:0 0 10px rgba(0,0,0,0.1);}
.left-panel{width:200px; border-right:1px solid #ddd; padding:20px; background:#fafafa;}
.right-panel{flex:1; padding:20px;}
.bubble{width:30px; height:30px; border-radius:50%; display:inline-block; line-height:30px; text-align:center; margin:5px; cursor:pointer; background:#eee;}
.bubble.attempted{background:#4caf50; color:white;}
.bubble.current{border:2px solid #2196f3;}
.question{margin-bottom:20px;}
button{padding:10px 15px; margin-top:10px;}
.navigation{margin-top:20px;}
</style>
</head>
<body>

<div class="container">
    <!-- Left Panel: Question Bubbles -->
    <div class="left-panel">
        <h3>Questions</h3>
        <?php foreach($questions as $index => $qrow){ ?>
            <div class="bubble" id="bubble-<?= $index ?>" onclick="showQuestion(<?= $index ?>)"><?= $index+1 ?></div>
        <?php } ?>
    </div>

    <!-- Right Panel: Question Display -->
    <div class="right-panel">
        <form id="mockForm" action="result.php" method="post">
            <?php foreach($questions as $index => $qrow){ ?>
                <div class="question" id="question-<?= $index ?>" style="display:<?= $index===0 ? 'block' : 'none' ?>">
                    <p><b>Q<?= $index+1 ?>. <?= $qrow['question'] ?></b></p>
                    <input type="radio" name="ans[<?= $qrow['id'] ?>]" value="A" onclick="markAttempted(<?= $index ?>)"> <?= $qrow['option_a'] ?><br>
                    <input type="radio" name="ans[<?= $qrow['id'] ?>]" value="B" onclick="markAttempted(<?= $index ?>)"> <?= $qrow['option_b'] ?><br>
                    <input type="radio" name="ans[<?= $qrow['id'] ?>]" value="C" onclick="markAttempted(<?= $index ?>)"> <?= $qrow['option_c'] ?><br>
                    <input type="radio" name="ans[<?= $qrow['id'] ?>]" value="D" onclick="markAttempted(<?= $index ?>)"> <?= $qrow['option_d'] ?><br>
                </div>
            <?php } ?>

            <div class="navigation">
                <button type="button" onclick="prevQuestion()">Previous</button>
                <button type="button" onclick="nextQuestion()">Next</button>
                <button type="submit">Submit Exam</button>
            </div>
        </form>
    </div>
</div>

<script>
let current = 0;
const total = <?= $total ?>;

function showQuestion(index){
    document.getElementById('question-'+current).style.display = 'none';
    document.getElementById('question-'+index).style.display = 'block';
    document.getElementById('bubble-'+current).classList.remove('current');
    document.getElementById('bubble-'+index).classList.add('current');
    current = index;
}

function nextQuestion(){
    if(current < total-1) showQuestion(current+1);
}

function prevQuestion(){
    if(current > 0) showQuestion(current-1);
}

function markAttempted(index){
    document.getElementById('bubble-'+index).classList.add('attempted');
}

// Initialize first bubble as current
document.getElementById('bubble-0').classList.add('current');
</script>

</body>
</html>
