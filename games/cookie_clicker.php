<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cookie Clicker - Quantum Arcade</title>
<style>
body {
    margin: 0;
    background-color: #1e1e1e;
    color: #e0e0e0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
header {
    background: linear-gradient(90deg, #3a3a3a, #2c2c2c);
    padding: 30px 20px;
    text-align: center;
    color: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.7);
    border-bottom: 2px solid #444;
}
header h1 {
    font-size: 2.5em;
    margin: 0;
    text-shadow: 1px 1px 5px #000;
}
.container {
    max-width: 500px;
    margin: 40px auto;
    background-color: #2f2f2f;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.7);
    text-align: center;
}
#cookie {
    width: 180px;
    height: 180px;
    cursor: pointer;
    margin: 20px 0;
    border-radius: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.6);
    transition: transform 0.1s;
}
#cookie:active {
    transform: scale(0.95);
}
.score-board {
    margin: 10px 0 20px;
    font-size: 1.3em;
    font-weight: bold;
}
button {
    padding: 12px 30px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    border-radius: 10px;
    background-color: #3a3a3a;
    color: #fff;
    font-weight: bold;
    box-shadow: 0 6px 15px rgba(0,0,0,0.6);
    transition: background 0.3s, transform 0.2s;
}
button:hover {
    background-color: #4a4a4a;
    transform: translateY(-3px);
}
.back-btn {
    margin-top: 20px;
}
.back-btn a {
    display: inline-block;
    color: #fff;
    text-decoration: none;
    padding: 12px 30px;
    background-color: #3a3a3a;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.6);
    font-weight: bold;
    transition: background 0.3s, transform 0.2s;
}
.back-btn a:hover {
    background-color: #4a4a4a;
    transform: translateY(-3px);
}
</style>
</head>
<body>
<header>
    <h1>🍪 Cookie Clicker - Quantum Arcade</h1>
</header>

<div class="container">
    <div class="score-board">
        Cookies: <span id="cookies">0</span>
    </div>
    <img src="cookie.webp" id="cookie" alt="Cookie">
    <div>
        <button id="autoClicker">Buy Auto Clicker (10 cookies)</button>
    </div>
    <div class="back-btn">
        <a href="../index.php">⬅ Back to Arcade</a>
    </div>
</div>

<script>
let cookies = 0;
let autoClickers = 0;
const cookieEl = document.getElementById('cookies');
const cookieBtn = document.getElementById('cookie');
const autoBtn = document.getElementById('autoClicker');

cookieBtn.addEventListener('click', ()=>{
    cookies++;
    cookieEl.textContent = cookies;
});

autoBtn.addEventListener('click', ()=>{
    if(cookies >= 10){
        cookies -= 10;
        autoClickers++;
        cookieEl.textContent = cookies;
    }
});

setInterval(()=>{
    if(autoClickers > 0){
        cookies += autoClickers;
        cookieEl.textContent = cookies;
    }
}, 1000);
</script>
</body>
</html>
