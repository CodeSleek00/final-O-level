let answerData = "";

function loadQuestion(q, a){
    document.getElementById("questionText").innerText = q;
    document.getElementById("answerBox").innerText = a;
    answerData = a;
    document.getElementById("answerBox").style.display = "none";
}

function toggleAnswer(){
    let box = document.getElementById("answerBox");
    box.style.display = box.style.display === "none" ? "block" : "none";
}

function runCode(){
    let code = document.getElementById("codeEditor").value;
    document.getElementById("output").srcdoc = code;
}
