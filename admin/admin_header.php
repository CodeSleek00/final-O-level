<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'Admin Panel' ?></title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="admin-header">
        <div class="admin-header-content">
            <h1>Admin Dashboard</h1>
            <nav class="admin-nav">
                <a href="admin_home.php">🏠 Home</a>
                <a href="add_subject.php">📚 Subjects</a>
                <a href="add_question.php">❓ Questions</a>
                <a href="add_chapter.php">📖 Chapters</a>
                <a href="add_practical_question.php">🧪 Practical</a>
                <a href="add_shortcut.php">⌨️ Shortcuts</a>
            </nav>
        </div>
    </div>
