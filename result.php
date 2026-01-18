<?php
include "db_connect.php";

$answers = $_POST['ans'] ?? [];

$total_attempted = count($answers);
$correct = 0;
$wrong = 0;

// Prepare detailed summary array
$summary = [];

// Loop through answers
foreach($answers as $qid => $ans){
    $res = $conn->query("SELECT * FROM questions WHERE id=$qid")->fetch_assoc();
    
    $is_correct = $res['correct_option'] == $ans;
    if($is_correct){
        $correct++;
        $status = "Correct";
    } else {
        $wrong++;
        $status = "Wrong";
    }

    $summary[] = [
        'question' => $res['question'],
        'selected' => $ans,
        'correct'  => $res['correct_option'],
        'options'  => [
            'A' => $res['option_a'],
            'B' => $res['option_b'],
            'C' => $res['option_c'],
            'D' => $res['option_d']
        ],
        'status'   => $status
    ];
}

// Fetch total questions in the set
$setid = isset($_POST['setid']) ? intval($_POST['setid']) : 0;
$sid   = isset($_POST['sid']) ? intval($_POST['sid']) : 0;

$total_q_res = $conn->query("SELECT COUNT(*) as t FROM questions WHERE subject_id=$sid AND set_id=$setid")->fetch_assoc();
$total_q = $total_q_res['t'];

$unattempted = $total_q - $total_attempted;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Exam Result</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body{
    font-family: 'Inter', sans-serif;
    background:#f4f6f8;
    margin:0; padding:0;
}
.container{
    max-width:1100px;
    margin:30px auto;
    padding:20px;
    background:white;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
    border-radius:8px;
}
h2{color:#111; margin-bottom:10px;}
.stats{
    display:flex; gap:30px; margin-bottom:20px;
}
.stat-box{
    flex:1; background:#f0f4f8; padding:20px; border-radius:8px; text-align:center;
}
.stat-box h3{margin:0; font-size:22px;}
.stat-box p{margin:5px 0 0; font-size:16px; color:#555;}
table{
    width:100%; border-collapse:collapse; margin-top:20px;
}
th, td{padding:12px; border:1px solid #ddd;}
th{background:#f5f5f5;}
.correct{color:green; font-weight:bold;}
.wrong{color:red; font-weight:bold;}
.unattempted{color:orange; font-weight:bold;}
canvas{margin-top:20px;}
</style>
</head>
<body>

<div class="container">
<h2>Exam Result</h2>

<div class="stats">
    <div class="stat-box">
        <h3><?= $total_q ?></h3>
        <p>Total Questions</p>
    </div>
    <div class="stat-box">
        <h3><?= $total_attempted ?></h3>
        <p>Attempted</p>
    </div>
    <div class="stat-box">
        <h3><?= $correct ?></h3>
        <p>Correct</p>
    </div>
    <div class="stat-box">
        <h3><?= $wrong ?></h3>
        <p>Wrong</p>
    </div>
    <div class="stat-box">
        <h3><?= $unattempted ?></h3>
        <p>Unattempted</p>
    </div>
</div>

<!-- Pie Chart -->
<canvas id="resultChart" width="400" height="400"></canvas>

<h3>Detailed Summary</h3>
<table>
<tr>
    <th>Q No.</th>
    <th>Question</th>
    <th>Your Answer</th>
    <th>Correct Answer</th>
    <th>Status</th>
</tr>
<?php foreach($summary as $index => $s): 
    $your_ans_text = $s['options'][$s['selected']] ?? "Not Attempted";
    $correct_ans_text = $s['options'][$s['correct']];
?>
<tr>
    <td><?= $index+1 ?></td>
    <td><?= $s['question'] ?></td>
    <td><?= $s['selected'] ? $your_ans_text." (".$s['selected'].")" : "Not Attempted" ?></td>
    <td><?= $correct_ans_text." (".$s['correct'].")" ?></td>
    <td class="<?= strtolower($s['status']) ?>"><?= $s['selected'] ? $s['status'] : "Unattempted" ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>

<script>
const ctx = document.getElementById('resultChart').getContext('2d');
const resultChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Correct', 'Wrong', 'Unattempted'],
        datasets: [{
            data: [<?= $correct ?>, <?= $wrong ?>, <?= $unattempted ?>],
            backgroundColor: ['#4caf50','#f44336','#ff9800'],
            borderColor:'#fff',
            borderWidth:2
        }]
    },
    options:{
        responsive:true,
        plugins:{
            legend:{
                position:'bottom',
                labels:{padding:20, font:{size:14}}
            }
        }
    }
});
</script>

</body>
</html>
