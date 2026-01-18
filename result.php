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
    // Fetch full question info
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Exam Result</title>
<style>
body{font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;}
h2, h3{color:#333;}
table{border-collapse: collapse; width:100%; margin-top:20px; background:white;}
th, td{border:1px solid #ccc; padding:10px; text-align:left;}
th{background:#eee;}
.correct{color:green; font-weight:bold;}
.wrong{color:red; font-weight:bold;}
</style>
</head>
<body>

<h2>Exam Result</h2>

<p>Attempted: <?= $total_attempted ?></p>
<p>Correct: <?= $correct ?></p>
<p>Wrong: <?= $wrong ?></p>

<h3>Detailed Summary:</h3>
<table>
    <tr>
        <th>Q No.</th>
        <th>Question</th>
        <th>Your Answer</th>
        <th>Correct Answer</th>
        <th>Status</th>
    </tr>
    <?php foreach($summary as $index => $s){ 
        $your_ans_text = $s['options'][$s['selected']] ?? "Not Attempted";
        $correct_ans_text = $s['options'][$s['correct']];
    ?>
    <tr>
        <td><?= $index+1 ?></td>
        <td><?= $s['question'] ?></td>
        <td><?= $s['selected'] ? $your_ans_text." (".$s['selected'].")" : "Not Attempted" ?></td>
        <td><?= $correct_ans_text." (".$s['correct'].")" ?></td>
        <td class="<?= strtolower($s['status']) ?>"><?= $s['status'] ?></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
