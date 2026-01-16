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
<title>LibreOffice Writer Shortcut Keys | Faiz Computer Institute</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}
body{
    background:#f9fafb;
}
.container{
    max-width:1200px;
    margin:auto;
    padding:30px 15px;
}

/* Header */
.header{
    text-align:center;
    margin-bottom:35px;
}
.header h1{
    font-size:36px;
    color:#1f2937;
    margin-bottom:8px;
}
.header h1 i{
    color:#2563eb;
    margin-right:10px;
}
.header p{
    color:#6b7280;
    font-size:18px;
}

/* Search box */
.search-box{
    background:#fff;
    padding:20px;
    border-radius:14px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    margin-bottom:30px;
}
.search-row{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
}
.search-input{
    flex:1;
    position:relative;
}
.search-input i{
    position:absolute;
    top:50%;
    left:12px;
    transform:translateY(-50%);
    color:#9ca3af;
}
.search-input input{
    width:100%;
    padding:14px 14px 14px 38px;
    border:1px solid #d1d5db;
    border-radius:8px;
    font-size:15px;
}
.search-input input:focus{
    outline:none;
    border-color:#2563eb;
    box-shadow:0 0 0 2px rgba(37,99,235,.2);
}
.search-actions{
    display:flex;
    gap:10px;
}
.btn{
    padding:14px 22px;
    border:none;
    border-radius:8px;
    font-size:15px;
    cursor:pointer;
    display:flex;
    align-items:center;
    gap:8px;
}
.btn-primary{
    background:#2563eb;
    color:#fff;
}
.btn-primary:hover{ background:#1d4ed8; }
.btn-light{
    background:#e5e7eb;
    color:#374151;
}
.btn-light:hover{ background:#d1d5db; }

.result-info{
    margin-top:15px;
    font-size:14px;
    color:#4b5563;
}

/* Table */
.table-box{
    background:#fff;
    border-radius:14px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    overflow:hidden;
}
table{
    width:100%;
    border-collapse:collapse;
}
thead{
    background:#f3f4f6;
}
th,td{
    padding:16px 18px;
    text-align:left;
    border-bottom:1px solid #e5e7eb;
}
th{
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:.05em;
    color:#374151;
}
tr:hover{
    background:#f9fafb;
}

/* Keyboard key */
.keyboard-key{
    display:inline-block;
    padding:4px 8px;
    margin:2px;
    background:linear-gradient(145deg,#f0f0f0,#ffffff);
    border:1px solid #d1d5db;
    border-radius:4px;
    box-shadow:0 2px 3px rgba(0,0,0,0.1);
    font-weight:600;
    color:#374151;
}
.key-combination{
    white-space:nowrap;
}

/* Copy button */
.copy-btn{
    background:none;
    border:none;
    color:#9ca3af;
    cursor:pointer;
    font-size:16px;
}
.copy-btn:hover{
    color:#2563eb;
}

/* No data */
.no-data{
    text-align:center;
    padding:60px 20px;
    color:#9ca3af;
}
.no-data i{
    font-size:48px;
    margin-bottom:15px;
}
/* ===== BANNER ===== */
        .header {
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
        }
        

/* Responsive */
@media(max-width:600px){
    .header h1{ font-size:26px; }
    th,td{ padding:12px 10px; }
}
</style>
</head>

<body>

<?php include 'navbar.html'; ?>

<div class="container">

    <!-- Header -->
    <div class="header">
        <h1><i class="fas fa-file-word"></i>LibreOffice Writer Shortcut Keys</h1>
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
                        <button class="copy-btn" onclick="copyToClipboard('<?php echo htmlspecialchars($row['shortcut_key']); ?>')">
                            <i class="far fa-copy"></i>
                        </button>
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

<script>
function copyToClipboard(text){
    navigator.clipboard.writeText(text);
    alert("Copied: " + text);
}
</script>

</body>
</html>
 