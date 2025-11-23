<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cookie Clicker</title>
<style>
    body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #222;
        color: #fff;
        font-family: Arial, sans-serif;
    }
    #cookie {
        width: 150px;
        height: 150px;
        cursor: pointer;
        margin: 20px;
    }
    button {
        margin: 10px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        background-color: #fff;
        color: #000;
        font-weight: bold;
    }
</style>
</head>
<body>
<h2>Cookie Clicker</h2>
<div>Cookies: <span id="cookies">0</span></div>
<img src="cookie.webp" id="cookie" alt="Cookie">
<button id="autoClicker">Buy Auto Clicker (10 cookies)</button>
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