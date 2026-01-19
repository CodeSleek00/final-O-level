<?php
include("../db_connect.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = "LibreOffice Writer";

$sql = "SELECT * FROM shortcuts WHERE category='$category'";
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND (shortcut_key LIKE '%$search%' OR description LIKE '%$search%')";
}
$sql .= " ORDER BY shortcut_key ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- SEO TITLE -->
<title>LibreOffice Writer Shortcut Keys | M1-R5 Writer Shortcuts | O Level Shortcuts</title>

<!-- META DESCRIPTION -->
<meta name="description" content="Complete list of LibreOffice Writer keyboard shortcuts for M1-R5 O Level exam. Learn Writer shortcuts, keyboard shortcuts for O Level exam preparation. Best Writer shortcuts guide by Faiz Computer Institute.">

<!-- KEYWORDS -->
<meta name="keywords" content="Writer Shortcuts, LibreOffice Writer Shortcuts, Keyboard Shortcuts, M1-R5 Writer Shortcuts, O Level Shortcuts, Writer Shortcut Keys, O Level Exam Shortcuts, NIELIT Writer Shortcuts, Writer Keyboard Shortcuts">

<meta name="author" content="Faiz Computer Institute">
<meta name="robots" content="index, follow">

<!-- CANONICAL -->
<link rel="canonical" href="https://www.faizcomputerinstitute.com/shortcut/writer.php">

<!-- OPEN GRAPH -->
<meta property="og:title" content="LibreOffice Writer Shortcut Keys | O Level">
<meta property="og:description" content="Complete list of LibreOffice Writer keyboard shortcuts for O Level exam.">
<meta property="og:type" content="website">
<meta property="og:url" content="https://www.faizcomputerinstitute.com/shortcut/writer.php">
<meta property="og:image" content="https://www.faizcomputerinstitute.com/image/olevel.png">

<!-- TWITTER -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Writer Shortcut Keys | O Level">
<meta name="twitter:description" content="Complete LibreOffice Writer keyboard shortcuts guide.">

<title>LibreOffice Writer Shortcut Keys | Faiz Computer Institute</title>
<link rel="icon" type="image/png" href="../image/olevel.png">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>

<?php include 'navbar.html'; ?>

<div class="container">

    <!-- Header -->
    <div class="header">
        <h1>LibreOffice Writer Shortcut Keys</h1>
        <p>Master your document editing with these essential keyboard shortcuts</p>
    </div>

    <!-- Search -->
    <div class="search-box">
        <form method="GET">
            <div class="search-row">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search shortcuts or descriptions...">
                </div>
                <div class="search-actions">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>Search
                    </button>
                    <?php if(!empty($search)): ?>
                        <a href="?search=" class="btn btn-light">
                            <i class="fas fa-times"></i>Clear
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <?php if(!empty($search)): ?>
        <div class="result-info">
            Showing results for "<b><?php echo htmlspecialchars($search); ?></b>"
            (<?php echo $result->num_rows; ?> found)
        </div>
        <?php endif; ?>
    </div>

    <!-- Table -->
    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th><i class="fas fa-keyboard"></i> Shortcut</th>
                    <th><i class="fas fa-info-circle"></i> Description</th>
                </tr>
            </thead>
            <tbody>
            <?php if($result->num_rows>0): ?>
                <?php while($row=$result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <div class="key-combination">
                        <?php
                        $keys = explode('+',$row['shortcut_key']);
                        foreach($keys as $i=>$k):
                        ?>
                            <kbd class="keyboard-key"><?php echo htmlspecialchars(trim($k)); ?></kbd>
                            <?php if($i<count($keys)-1): ?><span>+</span><?php endif; ?>
                        <?php endforeach; ?>
                        </div>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['description']); ?>
                        
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">
                        <div class="no-data">
                            <i class="fas fa-search"></i>
                            <h3>No shortcuts found</h3>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


</body>
</html>
 