<?php
include("../db_connect.php");
$result = $conn->query("SELECT * FROM shortcuts WHERE category='LibreOffice Writer'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibreOffice Writer Shortcut Keys | Faiz Computer Institute</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

<?php include 'navbar.html'; ?>

<h2>LibreOffice Writer Shortcut Keys</h2>

<?php while($row = $result->fetch_assoc()) { ?>
    <div class="card">
        <b><?= $row['shortcut_key'] ?></b> → <?= $row['description'] ?>
    </div>
<?php } ?>
