<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<title>O Level || Faiz Computer Institute</title>

<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: #f5f7fa;
    padding: 30px;
}

.card-container {
    max-width: 1100px;
    margin: auto;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 60px;
    padding: 30px;
}

.card {
    background: #ffffff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.card img {
    width: 100%;
    height: 260px;
    object-fit: cover;
}

.card-content {
    padding: 16px;
}

.card-content p {
    font-size: 14px;
    color: #555;
    line-height: 1.5;
}

.card-content hr {
    border: none;
    height: 1px;
    background: #e5e5e5;
    margin: 14px 0;
}

.card-content button {
    padding: 12px 16px;
    border: none;
    background: #4f46e5;
    color: #fff;
    font-size: 13px;
    border-radius: 8px;
    cursor: pointer;
}

.card-content h1 {
    font-size: 22px;
    margin-bottom: 10px;
    color: #333;
    font-weight: bold;
}
@media (max-width: 768px) {
    .card-container {
        grid-template-columns: 1fr;
    }
    .card img {
        height: 190px;
    }
    .card-content h1 {
        font-size: 22px;
    }.card-container {
        gap: 20px;
    }
}

</style>

</head>
<?php include 'navbar.html'; ?>
<body>




<div class="card-container">

    <div class="card">
        <img src="../image/1(1).png" alt="Image">
        <div class="card-content">
            <h1>M1-R5 (IT TOOLS)</h1>
            <p>
               MCQ Questions (IT TOOLS) <br> Chapter Wise Practice || Mock Tests 
            </p>
            <hr>
            <a href="M1-R5.php"><button>Start Practice</button></a>
        </div>
    </div>

   <div class="card">
        <img src="../image/3.png" alt="Image">
        <div class="card-content">
            <h1>M2-R5 (Web Designing & Publishing)</h1>
            <p>
               MCQ Questions (Web Designing & Publishing) <br>  Chapter Wise Practice || Mock Tests 
            </p>
            <hr>
            <a href="M2-R5.php"><button>Start Practice</button></a>
        </div>
    </div>
    <div class="card">
        <img src="../image/4.png" alt="Image">
        <div class="card-content">
            <h1>M3-R5 (Python Programming)</h1>
            <p>
               MCQ Questions (Python Programming) <br> Chapter Wise Practice || Mock Tests
            </p>
            <hr>
            <a href="M3-R5.php"><button>Start Practice</button></a>
        </div>
    </div>
    <div class="card">
        <img src="../image/2.png" alt="Image">
        <div class="card-content">
            <h1>M4-R5 (IOT - Internet Of Things)</h1>
            <p>
               MCQ Questions (IOT - Internet Of Things) <br> Chapter Wise Practice || Mock Tests
            </p>
            <hr>
            <a href="M4-R5.php"><button>Start Practice</button></a>
        </div>
    </div>
   
</div>

</body>
</html>
