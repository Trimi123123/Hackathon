<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Breakout - Quantum Arcade</title>
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
    max-width: 1000px;
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
    display: block;
    margin: 0 auto;
}

.back-btn {
    margin-top: 25px;
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
    <h1>🏗️ Breakout - Quantum Arcade</h1>
</header>

<div class="container">
    <canvas id="game" width="900" height="600"></canvas>
</div>

<div class="back-btn">
    <a href="../index.php">⬅ Back to Arcade</a>
</div>

<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');

// Paddle
const paddle = {
    width: 150,
    height: 20,
    x: canvas.width/2 - 75,
    y: canvas.height - 40,
    speed: 10
};

let rightPressed = false;
let leftPressed = false;

// Ball
const ball = {
    x: canvas.width/2,
    y: canvas.height - 60,
    radius: 12,
    dx: 5,
    dy: -5
};

// Bricks
const brickRowCount = 6;
const brickColumnCount = 10;
const brickWidth = 70;
const brickHeight = 25;
const brickPadding = 10;
const brickOffsetTop = 50;
const brickOffsetLeft = 35;

let bricks = [];
for(let c=0;c<brickColumnCount;c++){
    bricks[c] = [];
    for(let r=0;r<brickRowCount;r++){
        bricks[c][r] = { x:0, y:0, status:1 };
    }
}

let score = 0;
let lives = 3;

function drawBricks(){
    for(let c=0;c<brickColumnCount;c++){
        for(let r=0;r<brickRowCount;r++){
            if(bricks[c][r].status===1){
                let brickX = (c*(brickWidth+brickPadding))+brickOffsetLeft;
                let brickY = (r*(brickHeight+brickPadding))+brickOffsetTop;
                bricks[c][r].x = brickX;
                bricks[c][r].y = brickY;
                ctx.fillStyle='green';
                ctx.fillRect(brickX, brickY, brickWidth, brickHeight);
            }
        }
    }
}

function drawBall(){
    ctx.beginPath();
    ctx.arc(ball.x, ball.y, ball.radius, 0, Math.PI*2);
    ctx.fillStyle='yellow';
    ctx.fill();
    ctx.closePath();
}

function drawPaddle(){
    ctx.fillStyle='lime';
    ctx.fillRect(paddle.x, paddle.y, paddle.width, paddle.height);
}

function collisionDetection(){
    // Brick collisions
    for(let c=0;c<brickColumnCount;c++){
        for(let r=0;r<brickRowCount;r++){
            let b = bricks[c][r];
            if(b.status===1){
                if(ball.x > b.x && ball.x < b.x + brickWidth &&
                   ball.y > b.y && ball.y < b.y + brickHeight){
                    ball.dy = -ball.dy;
                    b.status = 0;
                    score++;
                    if(score === brickRowCount*brickColumnCount){
                        alert('YOU WIN!');
                        document.location.reload();
                    }
                }
            }
        }
    }

    // Paddle collision
    if(ball.y + ball.radius > paddle.y &&
       ball.y - ball.radius < paddle.y + paddle.height &&
       ball.x + ball.radius > paddle.x &&
       ball.x - ball.radius < paddle.x + paddle.width){
        ball.dy = -Math.abs(ball.dy);
        ball.y = paddle.y - ball.radius;
    }
}

function drawScore(){
    ctx.fillStyle='white';
    ctx.font='22px Arial';
    ctx.fillText('Score: ' + score, 20, 30);
}

function drawLives(){
    ctx.fillStyle='white';
    ctx.font='22px Arial';
    ctx.fillText('Lives: ' + lives, canvas.width - 120, 30);
}

function draw(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    drawBricks();
    drawBall();
    drawPaddle();
    drawScore();
    drawLives();
    collisionDetection();

    // Ball movement
    ball.x += ball.dx;
    ball.y += ball.dy;

    // Wall collisions
    if(ball.x + ball.dx > canvas.width - ball.radius || ball.x + ball.dx < ball.radius) ball.dx = -ball.dx;
    if(ball.y - ball.radius < 0) ball.dy = -ball.dy;
    else if(ball.y + ball.radius > canvas.height){
        lives--;
        if(!lives){
            alert('GAME OVER');
            document.location.reload();
        } else {
            ball.x = canvas.width/2;
            ball.y = canvas.height-60;
            ball.dx = 5;
            ball.dy = -5;
            paddle.x = canvas.width/2 - paddle.width/2;
        }
    }

    // Paddle movement
    if(rightPressed && paddle.x < canvas.width - paddle.width) paddle.x += paddle.speed;
    if(leftPressed && paddle.x > 0) paddle.x -= paddle.speed;

    requestAnimationFrame(draw);
}

document.addEventListener('keydown', e=>{
    if(e.key==='ArrowRight') rightPressed=true;
    if(e.key==='ArrowLeft') leftPressed=true;
});
document.addEventListener('keyup', e=>{
    if(e.key==='ArrowRight') rightPressed=false;
    if(e.key==='ArrowLeft') leftPressed=false;
});

draw();
</script>
</body>
</html>
