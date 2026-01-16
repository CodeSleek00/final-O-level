<?php
include("../db_connect.php");

// Fetch all practical questions
$q = $conn->query("SELECT * FROM practical_questions ORDER BY subject, chapter");
$data = [];
while($row = $q->fetch_assoc()){
    $data[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Code Practice</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: #f8fafc;
        color: #1e293b;
        line-height: 1.6;
        height: 100vh;
        overflow: hidden;
    }

    .container {
        display: flex;
        flex-direction: column;
        height: 100vh;
        padding: 20px;
        gap: 20px;
    }

    .main-content {
        display: flex;
        flex: 1;
        gap: 20px;
        min-height: 0;
    }

    /* LEFT PANEL */
    .left-panel {
        flex: 0 0 30%;
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 2px solid #e2e8f0;
    }

    .question-header h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #334155;
    }

    .question-counter {
        background: #3b82f6;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    #questionBox {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .nav-btns {
        display: flex;
        gap: 12px;
        margin-top: auto;
    }

    .nav-btns button {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .nav-btns button:first-child {
        background: #f1f5f9;
        color: #475569;
    }

    .nav-btns button:first-child:hover {
        background: #e2e8f0;
    }

    .nav-btns button:last-child {
        background: #3b82f6;
        color: white;
    }

    .nav-btns button:last-child:hover {
        background: #2563eb;
    }

    /* CENTER PANEL */
    .center-panel {
        flex: 0 0 40%;
        display: flex;
        flex-direction: column;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }

    .editor-header {
        display: flex;
        gap: 12px;
        padding: 20px;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .editor-header button {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .editor-header button:first-child {
        background: #10b981;
        color: white;
    }

    .editor-header button:first-child:hover {
        background: #059669;
    }

    .editor-header button:last-child {
        background: #f59e0b;
        color: white;
    }

    .editor-header button:last-child:hover {
        background: #d97706;
    }

    #codeEditor {
        flex: 1;
        padding: 20px;
        border: none;
        font-family: 'Monaco', 'Courier New', monospace;
        font-size: 14px;
        line-height: 1.5;
        resize: none;
        background: #0f172a;
        color: #e2e8f0;
        outline: none;
    }

    /* RIGHT PANEL */
    .right-panel {
        flex: 0 0 30%;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }

    .output-header {
        padding: 20px;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .output-header h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #334155;
    }

    #output {
        width: 100%;
        height: calc(100% - 70px);
        border: none;
        background: white;
    }

    /* MOBILE RESPONSIVE - ROW LAYOUT */
    @media (max-width: 768px) {
        body {
            overflow-y: auto;
            height: auto;
        }

        .container {
            height: auto;
            min-height: 100vh;
            padding: 12px;
            gap: 12px;
        }

        .main-content {
            flex-direction: column;
            min-height: auto;
            gap: 12px;
        }

        /* Each panel becomes a row */
        .left-panel,
        .center-panel,
        .right-panel {
            flex: none;
            width: 100%;
            min-height: 300px;
            height: auto;
        }

        /* Adjust heights for better row layout */
        .left-panel {
            min-height: 250px;
            order: 1;
        }

        .center-panel {
            min-height: 300px;
            order: 2;
        }

        .right-panel {
            min-height: 300px;
            order: 3;
        }

        /* Button adjustments */
        .editor-header {
            flex-direction: row;
            flex-wrap: wrap;
        }

        .editor-header button {
            flex: 1;
            min-width: 120px;
        }

        /* Question box adjustments */
        #questionBox {
            min-height: 150px;
        }

        /* Navigation buttons */
        .nav-btns {
            flex-direction: row;
        }

        .nav-btns button {
            min-height: 44px;
        }
    }

    /* Small mobile adjustments */
    @media (max-width: 480px) {
        .container {
            padding: 8px;
            gap: 8px;
        }

        .left-panel,
        .center-panel,
        .right-panel {
            padding: 16px;
            min-height: 250px;
        }

        .question-header {
            flex-direction: column;
            gap: 12px;
            align-items: flex-start;
        }

        .question-header h3,
        .output-header h3 {
            font-size: 1.25rem;
        }

        #questionBox {
            font-size: 0.95rem;
            min-height: 120px;
        }

        .editor-header {
            flex-direction: column;
            gap: 8px;
        }

        .editor-header button {
            width: 100%;
            padding: 12px;
        }

        #codeEditor {
            padding: 16px;
            font-size: 13px;
        }

        .nav-btns {
            flex-direction: column;
            gap: 8px;
        }

        .nav-btns button {
            padding: 14px;
            font-size: 1rem;
        }
    }

    /* Very small screens */
    @media (max-width: 360px) {
        .left-panel,
        .center-panel,
        .right-panel {
            padding: 12px;
            min-height: 200px;
        }

        .question-header h3,
        .output-header h3 {
            font-size: 1.1rem;
        }

        #questionBox {
            padding: 12px;
            font-size: 0.9rem;
        }

        .editor-header button,
        .nav-btns button {
            padding: 10px;
            font-size: 0.9rem;
        }

        #codeEditor {
            padding: 12px;
            font-size: 12px;
        }
    }

    /* SCROLLBAR STYLING */
    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
</head>
<body>

<div class="container">
    <div class="main-content">

        <!-- LEFT PANEL -->
        <div class="left-panel">
            <div class="question-header">
                <h3>Code Challenge</h3>
                <div class="question-counter" id="questionCounter">0/0</div>
            </div>
            <div id="questionBox">Click Next to start practicing</div>
            <div class="nav-btns">
                <button onclick="prevQ()">← Previous</button>
                <button onclick="nextQ()">Next →</button>
            </div>
        </div>

        <!-- CENTER PANEL -->
        <div class="center-panel">
            <div class="editor-header">
                <button onclick="loadAnswer()">Show Answer</button>
                <button onclick="runCode()">▶ Run Code</button>
            </div>
            <textarea id="codeEditor" placeholder="Write your HTML code here...">
<!DOCTYPE html>
<html>
<body>

</body>
</html>
            </textarea>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right-panel">
            <div class="output-header">
                <h3>Preview</h3>
            </div>
            <iframe id="output" title="Code Output"></iframe>
        </div>

    </div>
</div>

<script>
const questions = <?= json_encode($data) ?>;
let index = -1;

function updateCounter() {
    const total = questions.length;
    const current = index >= 0 ? index + 1 : 0;
    document.getElementById("questionCounter").textContent = `${current}/${total}`;
}

function nextQ(){
    if(index < questions.length - 1){
        index++;
        showQuestion();
    }
}

function prevQ(){
    if(index > 0){
        index--;
        showQuestion();
    }
}

function showQuestion(){
    if(index >= 0 && index < questions.length) {
        document.getElementById("questionBox").innerHTML = `
            <strong>Subject:</strong> ${questions[index].subject}<br>
            <strong>Chapter:</strong> ${questions[index].chapter}<br><br>
            ${questions[index].question}
        `;

        updateCounter();

        // Reset editor
        document.getElementById("codeEditor").value =
`<!DOCTYPE html>
<html>
<body>

</body>
</html>`;

        // Clear output
        document.getElementById("output").srcdoc = "";
    }
}

function loadAnswer(){
    if(index >= 0 && index < questions.length){
        document.getElementById("codeEditor").value = questions[index].answer;
    }
}

function runCode(){
    const code = document.getElementById("codeEditor").value;
    document.getElementById("output").srcdoc = code;
}

// Initialize counter on load
document.addEventListener('DOMContentLoaded', () => {
    updateCounter();
});
</script>

</body>
</html>