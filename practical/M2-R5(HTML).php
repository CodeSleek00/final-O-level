<?php
include("../db_connect.php");

// Fetch all practical questions
$q = $conn->query("SELECT * FROM practical_questions WHERE subject='HTML' ORDER BY chapter, id");
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
        overflow-x: hidden;
    }

    .container {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        padding: 20px;
        gap: 20px;
    }

    .main-content {
        display: flex;
        flex: 1;
        gap: 20px;
        min-height: 600px;
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
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        min-width: 70px;
        text-align: center;
    }

    #questionBox {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
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
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    .nav-btns button {
        flex: 1;
        padding: 12px 20px;
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
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s ease;
        min-width: 140px;
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
        tab-size: 4;
    }

    /* RIGHT PANEL */
    .right-panel {
        flex: 0 0 30%;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        display: flex;
        flex-direction: column;
    }

    .output-header {
        padding: 20px;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        flex-shrink: 0;
    }

    .output-header h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #334155;
    }

    #output {
        flex: 1;
        width: 100%;
        border: none;
        background: white;
        min-height: 400px;
    }

    /* BANNER */
    .it-banner {
        background: url('../image/bg.svg');
        background-size: cover;
        background-position: center center;
        padding: 40px 20px;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        text-align: center;
        margin: 20px;
        background-color: black;
        color: white;
    }

    .it-banner h1 {
        font-size: 2.5rem;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .it-banner p {
        font-size: 1.1rem;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.6;
        opacity: 0.9;
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

    /* MOBILE RESPONSIVE */
    @media (max-width: 768px) {
        .container {
            padding: 15px;
            gap: 15px;
        }

        .main-content {
            flex-direction: column;
            min-height: auto;
            gap: 15px;
        }

        .left-panel,
        .center-panel,
        .right-panel {
            flex: none;
            width: 100%;
            min-height: auto;
        }

        .left-panel {
            min-height: 350px;
        }

        .center-panel {
            min-height: 500px;
        }

        .right-panel {
            min-height: 400px;
        }

        .it-banner {
            margin: 15px;
            padding: 30px 15px;
        }

        .it-banner h1 {
            font-size: 2rem;
        }

        .it-banner p {
            font-size: 1rem;
        }

        .question-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .question-counter {
            align-self: flex-end;
        }

        .editor-header {
            flex-wrap: wrap;
        }

        .editor-header button {
            min-width: calc(50% - 6px);
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 10px;
            gap: 10px;
        }

        .left-panel,
        .center-panel,
        .right-panel {
            padding: 15px;
        }

        .it-banner {
            margin: 10px;
            padding: 25px 15px;
        }

        .it-banner h1 {
            font-size: 1.75rem;
        }

        .question-header h3,
        .output-header h3 {
            font-size: 1.25rem;
        }

        #questionBox {
            padding: 15px;
            font-size: 0.95rem;
        }

        .editor-header {
            flex-direction: column;
        }

        .editor-header button {
            width: 100%;
            min-width: 100%;
        }

        .nav-btns {
            flex-direction: row;
        }

        .nav-btns button {
            padding: 14px;
        }

        #codeEditor {
            padding: 15px;
            font-size: 13px;
        }
    }

    /* Small screens */
    @media (max-width: 360px) {
        .it-banner h1 {
            font-size: 1.5rem;
        }

        .question-header h3 {
            font-size: 1.1rem;
        }

        .nav-btns {
            flex-direction: column;
        }

        #codeEditor {
            font-size: 12px;
            padding: 12px;
        }
    }
</style>
</head>
<body>
    <?php include 'navbar.html'; ?>
    
    <!-- BANNER -->
    <section class="it-banner">
        <h1>HTML Code Practice</h1>
        <p>
            Practice HTML coding challenges based on the latest NIELIT syllabus.
            Improve your coding skills with practical HTML questions designed for O Level students.
        </p>
    </section>

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
        const q = questions[index];
        document.getElementById("questionBox").innerHTML = `
            <div style="margin-bottom: 15px;">
               
                <strong style="color: #3b82f6;">Chapter:</strong> ${q.chapter}
            </div>
            <div style="background: white; padding: 15px; border-radius: 6px; border-left: 4px solid #3b82f6;">
                ${q.question}
            </div>
        `;

        updateCounter();

        // Reset editor
        document.getElementById("codeEditor").value = `<!DOCTYPE html>\n<html>\n<body>\n\n</body>\n</html>`;

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
    const iframe = document.getElementById("output");
    iframe.srcdoc = code;
}

// Initialize on load
document.addEventListener('DOMContentLoaded', () => {
    updateCounter();
    
    // Auto-resize iframe
    const iframe = document.getElementById('output');
    iframe.onload = function() {
        this.style.height = this.contentWindow.document.body.scrollHeight + 'px';
    };
});
</script>

</body>
</html>