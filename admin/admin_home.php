<?php
session_start();

// Default password - Change this to your desired password
$admin_password = "admin123"; // Change this password

$login_error = "";

// Handle login
if (isset($_POST['login'])) {
    $entered_password = $_POST['password'];
    if ($entered_password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_home.php');
        exit();
    } else {
        $login_error = "Incorrect password!";
    }
}

// If not logged in, show login form
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <link rel="stylesheet" href="admin_style.css">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                background: #f8f9fa;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .login-container {
                width: 100%;
                max-width: 420px;
            }
            .login-box {
                background: #ffffff;
                padding: 48px 40px;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                border: 1px solid #e5e7eb;
            }
            .login-header {
                text-align: center;
                margin-bottom: 32px;
            }
            .login-header h1 {
                font-size: 24px;
                font-weight: 600;
                color: #111827;
                margin-bottom: 8px;
                letter-spacing: -0.5px;
            }
            .login-header p {
                color: #6b7280;
                font-size: 14px;
                font-weight: 400;
            }
            .form-group {
                margin-bottom: 20px;
            }
            .form-group label {
                display: block;
                font-size: 14px;
                font-weight: 500;
                color: #374151;
                margin-bottom: 8px;
            }
            .form-group input {
                width: 100%;
                padding: 12px 16px;
                font-size: 14px;
                border: 1px solid #d1d5db;
                border-radius: 6px;
                background: #ffffff;
                transition: all 0.2s;
                font-family: inherit;
            }
            .form-group input:focus {
                outline: none;
                border-color: #2563eb;
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            }
            .btn-login {
                width: 100%;
                padding: 12px 16px;
                background: #2563eb;
                color: #ffffff;
                border: none;
                border-radius: 6px;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s;
                font-family: inherit;
            }
            .btn-login:hover {
                background: #1d4ed8;
            }
            .btn-login:active {
                transform: scale(0.98);
            }
            .alert-error {
                background: #fef2f2;
                border: 1px solid #fecaca;
                color: #991b1b;
                padding: 12px 16px;
                border-radius: 6px;
                font-size: 14px;
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="login-box">
                <div class="login-header">
                    <h1>Admin Login</h1>
                    <p>Enter your password to continue</p>
                </div>

                <?php if ($login_error): ?>
                    <div class="alert-error">
                        <?= htmlspecialchars($login_error) ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" 
                               placeholder="Enter password" 
                               required autofocus>
                    </div>

                    <button type="submit" name="login" class="btn-login">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// User is logged in, show dashboard
include "../db_connect.php";

// ===== COUNTS =====
$subjects = $conn->query("SELECT COUNT(*) total FROM subjects")->fetch_assoc()['total'];
$sets = $conn->query("SELECT COUNT(*) total FROM test_sets")->fetch_assoc()['total'];
$mcqs = $conn->query("SELECT COUNT(*) total FROM questions")->fetch_assoc()['total'];
$chapters = $conn->query("SELECT COUNT(*) total FROM chapters")->fetch_assoc()['total'];
$chapter_q = $conn->query("SELECT COUNT(*) total FROM chapter_questions")->fetch_assoc()['total'];
$practicals = $conn->query("SELECT COUNT(*) total FROM practical_questions")->fetch_assoc()['total'];
$shortcut_cat = $conn->query("SELECT COUNT(*) total FROM categories")->fetch_assoc()['total'];
$shortcuts = $conn->query("SELECT COUNT(*) total FROM shortcuts")->fetch_assoc()['total'];

$page_title = "Admin Dashboard";
include "admin_header.php";
?>

<div class="admin-container">
    <div class="section-header">
        <h2>📊 Dashboard Overview</h2>
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <h3>Total Subjects</h3>
            <p class="number"><?= $subjects ?></p>
        </div>
        <div class="dashboard-card">
            <h3>Mock Test Sets</h3>
            <p class="number"><?= $sets ?></p>
        </div>
        <div class="dashboard-card">
            <h3>Total MCQs</h3>
            <p class="number"><?= $mcqs ?></p>
        </div>
        <div class="dashboard-card">
            <h3>Total Chapters</h3>
            <p class="number"><?= $chapters ?></p>
        </div>
        <div class="dashboard-card">
            <h3>Chapter Questions</h3>
            <p class="number"><?= $chapter_q ?></p>
        </div>
        <div class="dashboard-card">
            <h3>Practical Questions</h3>
            <p class="number"><?= $practicals ?></p>
        </div>
        <div class="dashboard-card">
            <h3>Shortcut Categories</h3>
            <p class="number"><?= $shortcut_cat ?></p>
        </div>
        <div class="dashboard-card">
            <h3>Shortcut Keys</h3>
            <p class="number"><?= $shortcuts ?></p>
        </div>
    </div>

    <div class="section-header">
        <h2>⚙️ Quick Actions</h2>
    </div>

    <div class="action-grid">
        <a href="add_subject.php" class="action-btn">
            <div class="action-btn-icon">📚</div>
            <div class="action-btn-content">
                <h3>Add Subject</h3>
                <p>Create a new subject</p>
            </div>
        </a>

        <a href="add_set.php" class="action-btn">
            <div class="action-btn-icon">📝</div>
            <div class="action-btn-content">
                <h3>Add Mock Test Set</h3>
                <p>Create a new test set</p>
            </div>
        </a>

        <a href="add_question.php" class="action-btn">
            <div class="action-btn-icon">❓</div>
            <div class="action-btn-content">
                <h3>Add MCQ Question</h3>
                <p>Add multiple choice question</p>
            </div>
        </a>

        <a href="add_chapter.php" class="action-btn">
            <div class="action-btn-icon">📖</div>
            <div class="action-btn-content">
                <h3>Add Chapter</h3>
                <p>Create a new chapter</p>
            </div>
        </a>

        <a href="add_chapter_question.php" class="action-btn">
            <div class="action-btn-icon">📘</div>
            <div class="action-btn-content">
                <h3>Add Chapter Question</h3>
                <p>Add question to a chapter</p>
            </div>
        </a>

        <a href="add_practical_question.php" class="action-btn">
            <div class="action-btn-icon">🧪</div>
            <div class="action-btn-content">
                <h3>Add Practical Question</h3>
                <p>Add practical/coding question</p>
            </div>
        </a>

        <a href="add_category.php" class="action-btn">
            <div class="action-btn-icon">🏷️</div>
            <div class="action-btn-content">
                <h3>Add Shortcut Category</h3>
                <p>Create shortcut category</p>
            </div>
        </a>

        <a href="add_shortcut.php" class="action-btn">
            <div class="action-btn-icon">⌨️</div>
            <div class="action-btn-content">
                <h3>Add Shortcut Key</h3>
                <p>Add keyboard shortcut</p>
            </div>
        </a>
    </div>
</div>

</body>
</html>
