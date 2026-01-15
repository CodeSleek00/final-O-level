<?php
include("../db_connect.php");
$result = $conn->query("SELECT * FROM shortcuts WHERE category='LibreOffice Writer'");
?>

<?php include 'navbar.html'; ?>

<h2>LibreOffice Writer Shortcut Keys</h2>

<?php while($row = $result->fetch_assoc()) { ?>
    <div class="card">
        <b><?= $row['shortcut_key'] ?></b> → <?= $row['description'] ?>
    </div>
<?php } ?>
