<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_home.php");
    exit;
}

include "../db_connect.php";

/* ===== UPDATE LOGIC ===== */
if (isset($_POST['update_question'])) {

    $id       = intval($_POST['id']);
    $subject  = trim($_POST['subject']);
    $chapter  = trim($_POST['chapter']);
    $question = trim($_POST['question']);
    $answer   = trim($_POST['answer']);

    $image_sql = "";

    if (!empty($_FILES['image']['name'])) {

        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $allowed = ['image/jpeg','image/png','image/jpg','image/gif'];

        if (in_array($_FILES['image']['type'], $allowed)) {

            $image_name = time() . "_" . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir.$image_name);

            $image_sql = ", image='$image_name'";
        }
    }

    $conn->query("
        UPDATE practical_questions SET
        subject='$subject',
        chapter='$chapter',
        question='$question',
        answer='$answer'
        $image_sql
        WHERE id=$id
    ");

    echo "<script>alert('Question Updated Successfully');window.location='edit_practical.php';</script>";
    exit;
}

/* ===== FETCH FOR EDIT ===== */
$edit = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit = $conn->query("SELECT * FROM practical_questions WHERE id=$id")->fetch_assoc();
}

/* ===== FETCH ALL QUESTIONS ===== */
$questions = $conn->query("SELECT * FROM practical_questions ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Practical Questions</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body{font-family:Poppins;background:#f4f6f9;padding:30px}
table{width:100%;border-collapse:collapse;background:#fff}
th,td{padding:12px;border-bottom:1px solid #ddd}
th{background:#0d6efd;color:#fff}
a.btn{padding:6px 12px;background:#0d6efd;color:#fff;text-decoration:none;border-radius:6px}
.form-box{background:#fff;padding:20px;margin-bottom:30px;border-radius:10px}
input,textarea{width:100%;padding:10px;margin-bottom:10px}
button{background:#198754;color:#fff;padding:10px 18px;border:none;border-radius:6px;cursor:pointer}
img{max-width:120px;border-radius:6px;margin-top:5px}
</style>
</head>

<body>

<h2>📝 Edit Practical Questions</h2>

<?php if($edit){ ?>
<div class="form-box">
    <h3>Edit Question ID: <?= $edit['id'] ?></h3>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $edit['id'] ?>">

        <input type="text" name="subject" value="<?= htmlspecialchars($edit['subject']) ?>" required>
        <input type="text" name="chapter" value="<?= htmlspecialchars($edit['chapter']) ?>" required>

        <textarea name="question" rows="4" required><?= htmlspecialchars($edit['question']) ?></textarea>
        <textarea name="answer" rows="4" required><?= htmlspecialchars($edit['answer']) ?></textarea>

        <?php if($edit['image']){ ?>
            <img src="uploads/<?= $edit['image'] ?>">
        <?php } ?>

        <input type="file" name="image">
        <button type="submit" name="update_question">Update Question</button>
    </form>
</div>
<?php } ?>

<table>
<tr>
    <th>ID</th>
    <th>Subject</th>
    <th>Chapter</th>
    <th>Question</th>
    <th>Action</th>
</tr>

<?php while($q = $questions->fetch_assoc()){ ?>
<tr>
    <td><?= $q['id'] ?></td>
    <td><?= $q['subject'] ?></td>
    <td><?= $q['chapter'] ?></td>
    <td><?= substr(strip_tags($q['question']),0,60) ?>...</td>
    <td>
        <a class="btn" href="edit_practical.php?edit=<?= $q['id'] ?>">Edit</a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>
