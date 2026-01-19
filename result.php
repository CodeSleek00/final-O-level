<?php
include "db_connect.php";

$answers = $_POST['ans'] ?? [];

$total_attempted = count($answers);
$correct = 0;
$wrong = 0;

$summary = [];

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
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- SEO TITLE -->
<title>O Level Exam Result | Mock Test Result | NIELIT O Level Result</title>

<!-- META DESCRIPTION -->
<meta name="description" content="View your O Level mock test results instantly. Check your O Level exam performance, correct answers, and detailed analysis. Best O Level result portal by Faiz Computer Institute.">

<!-- KEYWORDS -->
<meta name="keywords" content="O Level Result, O Level Exam Result, Mock Test Result, NIELIT O Level Result, O Level Score, O Level Performance, O Level Test Result, O Level Exam Analysis">

<meta name="author" content="Faiz Computer Institute">
<meta name="robots" content="index, follow">

<!-- CANONICAL -->
<link rel="canonical" href="https://www.faizcomputerinstitute.com/result.php">

<!-- OPEN GRAPH -->
<meta property="og:title" content="O Level Exam Result | Mock Test Result">
<meta property="og:description" content="View your O Level mock test results with detailed analysis and performance metrics.">
<meta property="og:type" content="website">
<meta property="og:url" content="https://www.faizcomputerinstitute.com/result.php">
<meta property="og:image" content="https://www.faizcomputerinstitute.com/image/olevel.png">

<!-- TWITTER -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="O Level Exam Result | NIELIT">
<meta name="twitter:description" content="View your O Level mock test results instantly.">

<title>Exam Result</title>
<link rel="icon" type="image/png" href="image/olevel.png">
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 20px;
}
.container {
    max-width: 1000px;
    margin: 0 auto;
    background: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.header {
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #333;
}
.stats {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}
.stat-item {
    text-align: center;
    padding: 10px;
    background: #f8f8f8;
    border-radius: 5px;
    flex: 1;
    margin: 0 5px;
}
.stat-number {
    font-size: 24px;
    font-weight: bold;
}
.stat-label {
    font-size: 14px;
    color: #666;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}
th {
    background-color: #f2f2f2;
}
.correct {
    color: green;
    font-weight: bold;
}
.wrong {
    color: red;
    font-weight: bold;
}
.unattempted {
    color: orange;
    font-weight: bold;
}
</style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Exam Result</h1>
    </div>

    <div class="stats">
       
        <div class="stat-item">
            <div class="stat-number"><?= $total_attempted ?></div>
            <div class="stat-label">Attempted</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><?= $correct ?></div>
            <div class="stat-label">Correct</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><?= $wrong ?></div>
            <div class="stat-label">Wrong</div>
        </div>
       
    </div>

    <h3>Question Summary</h3>
    <table>
        <tr>
            <th>Q.No.</th>
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

</body>
</html>