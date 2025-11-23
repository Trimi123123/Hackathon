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
<title>Flappy Bird - Quantum Arcade</title>
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
    max-width: 600px;
    margin: 40px auto;
    background-color: #2f2f2f;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.7);
    text-align: center;
}
canvas {
    background-color: #1e1e1e;
    border: 3px solid #444;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.9);
    margin-bottom: 25px;
}
.score-board {
    margin: 15px 0 25px;
    font-size: 1.2em;
    font-weight: bold;
}
.back-btn {
    margin-top: 10px;
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
#resetButton {
    display: none;
    margin-top: 15px;
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
<header>
    <h1>🐦 Flappy Bird - Quantum Arcade</h1>
</header>
<div class="container">
    <div class="score-board">
        Score: <span id="score">0</span>
    </div>
    <canvas id="game" width="400" height="600"></canvas>
    <button id="resetButton">Reset</button>
    <div class="back-btn">
        <a href="../index.php">⬅ Back to Arcade</a>
    </div>
</div>

<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');
const resetButton = document.getElementById('resetButton');

let bird, pipes, frame, score;

function init(){
    bird = { x: 80, y: 300, width: 30, height: 30, gravity: 0.3, velocity: 0, jump: -7 };
    pipes = [];
    frame = 0;
    score = 0;
    document.getElementById('score').textContent = score;
    resetButton.style.display = 'none';
    update();
}

function drawBird(){
    ctx.fillStyle = 'lime';
    ctx.fillRect(bird.x, bird.y, bird.width, bird.height);
}

function drawPipes(){
    ctx.fillStyle = 'red';
    pipes.forEach(pipe => {
        ctx.fillRect(pipe.x, 0, 50, pipe.top);
        ctx.fillRect(pipe.x, canvas.height - pipe.bottom, 50, pipe.bottom);
    });
}

function movePipes(){
    pipes.forEach(pipe => pipe.x -= 2);
    if(pipes.length && pipes[0].x + 50 < 0){
        pipes.shift();
        score++;
        document.getElementById('score').textContent = score;
    }
}

function addPipe(){
    let top = Math.random() * (canvas.height - 150 - 100) + 50;
    let bottom = canvas.height - top - 150;
    pipes.push({ x: canvas.width, top: top, bottom: bottom });
}

function collision(){
    if(bird.y + bird.height > canvas.height || bird.y < 0) return true;
    for(let pipe of pipes){
        if(bird.x < pipe.x + 50 && bird.x + bird.width > pipe.x &&
           (bird.y < pipe.top || bird.y + bird.height > canvas.height - pipe.bottom)){
               return true;
           }
    }
    return false;
}

function jump(){
    bird.velocity = bird.jump;
}

function update(){
    ctx.clearRect(0,0,canvas.width,canvas.height);

    bird.velocity += bird.gravity;
    bird.y += bird.velocity;

    if(frame % 100 === 0) addPipe();
    movePipes();

    drawPipes();
    drawBird();

    frame++;

    if(collision()){
        resetButton.style.display = 'block';
        return;
    }

    requestAnimationFrame(update);
}

document.addEventListener('keydown', e => { if(e.key === ' ') jump(); });
document.addEventListener('click', jump);
resetButton.addEventListener('click', init);

init();
</script>
</body>
</html>
