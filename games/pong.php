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
<title>Pong - Quantum Arcade</title>
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
    max-width: 900px;
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
</style>
</head>
<body>
<header>
    <h1>🏓 Pong - Quantum Arcade</h1>
</header>
<div class="container">
    <div class="score-board">
        Player: <span id="playerScore">0</span> | AI: <span id="aiScore">0</span>
    </div>
    <canvas id="pong" width="800" height="500"></canvas>
    <div class="back-btn">
        <a href="../index.php">⬅ Back to Arcade</a>
    </div>
</div>
<script>
const canvas = document.getElementById('pong');
const ctx = canvas.getContext('2d');

const paddleWidth = 10;
const paddleHeight = 100;
const ballRadius = 12;

let player = { x: 0, y: canvas.height/2 - paddleHeight/2, width: paddleWidth, height: paddleHeight, dy: 0 };
let ai = { x: canvas.width - paddleWidth, y: canvas.height/2 - paddleHeight/2, width: paddleWidth, height: paddleHeight, dy: 4 };
let ball = { x: canvas.width/2, y: canvas.height/2, dx: 6, dy: 6, radius: ballRadius };

let playerScore = 0;
let aiScore = 0;

function drawRect(x,y,w,h,color){ ctx.fillStyle=color; ctx.fillRect(x,y,w,h); }
function drawCircle(x,y,r,color){ ctx.fillStyle=color; ctx.beginPath(); ctx.arc(x,y,r,0,Math.PI*2); ctx.fill(); }

function draw(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    drawRect(player.x, player.y, player.width, player.height, 'lime');
    drawRect(ai.x, ai.y, ai.width, ai.height, 'red');
    drawCircle(ball.x, ball.y, ball.radius, 'yellow');
}

function movePlayer(){
    player.y += player.dy;
    if(player.y < 0) player.y = 0;
    if(player.y + paddleHeight > canvas.height) player.y = canvas.height - paddleHeight;
}

function moveAI(){
    if(ball.y < ai.y + ai.height/2) ai.y -= ai.dy;
    if(ball.y > ai.y + ai.height/2) ai.y += ai.dy;
    if(ai.y < 0) ai.y = 0;
    if(ai.y + paddleHeight > canvas.height) ai.y = canvas.height - paddleHeight;
}

function moveBall(){
    ball.x += ball.dx;
    ball.y += ball.dy;

    if(ball.y - ball.radius < 0 || ball.y + ball.radius > canvas.height) ball.dy *= -1;

    if(ball.x - ball.radius < player.x + player.width && ball.y > player.y && ball.y < player.y + player.height){
        ball.dx *= -1;
        ball.x = player.x + player.width + ball.radius;
    }

    if(ball.x + ball.radius > ai.x && ball.y > ai.y && ball.y < ai.y + ai.height){
        ball.dx *= -1;
        ball.x = ai.x - ball.radius;
    }

    if(ball.x - ball.radius < 0){ aiScore++; resetBall(); }
    if(ball.x + ball.radius > canvas.width){ playerScore++; resetBall(); }

    document.getElementById('playerScore').textContent = playerScore;
    document.getElementById('aiScore').textContent = aiScore;
}

function resetBall(){
    ball.x = canvas.width/2;
    ball.y = canvas.height/2;
    ball.dx *= -1;
    ball.dy = 6 * (Math.random() > 0.5 ? 1 : -1);
}

document.addEventListener('keydown', e => {
    if(e.key === 'ArrowUp') player.dy = -6;
    if(e.key === 'ArrowDown') player.dy = 6;
});
document.addEventListener('keyup', e => {
    if(e.key === 'ArrowUp' || e.key === 'ArrowDown') player.dy = 0;
});

function update(){
    movePlayer();
    moveAI();
    moveBall();
    draw();
    requestAnimationFrame(update);
}

update();
</script>
</body>
</html>