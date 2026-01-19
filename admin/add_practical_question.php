<?php
$page_title = "Add Practical Question";
include "admin_header.php";
?>

<div class="admin-container">
    <div class="form-container">
        <div class="form-header">
            <h2>🧪 Add Practical Question</h2>
            <p>Create a new practical/coding question with optional image</p>
        </div>

        <form action="save_question.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="subject">Subject</label>
                <select id="subject" name="subject" required>
                    <option value="">Select Subject</option>
                    <option value="HTML">HTML</option>
                    <option value="CSS">CSS</option>
                    <option value="JavaScript">JavaScript</option>
                    <option value="LibreOffice Calc">LibreOffice Calc</option>
                    <option value="LibreOffice Impress">LibreOffice Impress</option>
                    <option value="LibreOffice Writer">LibreOffice Writer</option>
                    <option value="Python">Python</option>
                    <option value="IOT">IOT</option>
                </select>
            </div>

            <div class="form-group">
                <label for="chapter">Chapter</label>
                <input type="text" id="chapter" name="chapter" 
                       placeholder="e.g., Forms, Tables, Functions" 
                       required>
            </div>

            <div class="form-group">
                <label for="question">Question</label>
                <textarea id="question" name="question" 
                          placeholder="Enter the practical question here..." 
                          required></textarea>
            </div>

            <div class="form-group">
                <label for="answer">Answer (Code/Solution)</label>
                <textarea id="answer" name="answer" 
                          class="code"
                          placeholder="Enter the code or solution here..."></textarea>
            </div>

            <div class="form-group">
                <label for="image">Question Image (Optional)</label>
                <div class="file-upload-wrapper">
                    <input type="file" id="image" name="image" accept="image/*">
                </div>
                <small style="color: #6b7280; font-size: 0.85rem; margin-top: 5px; display: block;">
                    Supported formats: JPG, PNG, GIF
                </small>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Save Question</button>
        </form>

        <a href="admin_home.php" class="btn-back">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
