<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pong Game</title>
<style>
    body {
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: #000;
        color: #fff;
        font-family: Arial, sans-serif;
        flex-direction: column;
    }
    canvas {
        border: 2px solid #fff;
        background: #111;
    }
    h2 { margin-bottom: 5px; }
</style>
</head>
<body>
<h2>Pong</h2>
<canvas id="pong" width="600" height="400"></canvas>
<div>Player: <span id="playerScore">0</span> | AI: <span id="aiScore">0</span></div>
<script>
const canvas = document.getElementById('pong');
const ctx = canvas.getContext('2d');

const paddleWidth = 10;
const paddleHeight = 100;
const ballRadius = 8;

let player = { x: 0, y: canvas.height/2 - paddleHeight/2, width: paddleWidth, height: paddleHeight, dy: 0 };
let ai = { x: canvas.width - paddleWidth, y: canvas.height/2 - paddleHeight/2, width: paddleWidth, height: paddleHeight, dy: 2 };
let ball = { x: canvas.width/2, y: canvas.height/2, dx: 4, dy: 4, radius: ballRadius };

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

    // Player paddle collision
    if(ball.x - ball.radius < player.x + player.width &&
       ball.y > player.y && ball.y < player.y + player.height){
        ball.dx *= -1;
        ball.x = player.x + player.width + ball.radius;
    }

    // AI paddle collision
    if(ball.x + ball.radius > ai.x &&
       ball.y > ai.y && ball.y < ai.y + ai.height){
        ball.dx *= -1;
        ball.x = ai.x - ball.radius;
    }

    // Score update
    if(ball.x - ball.radius < 0){
        aiScore++;
        resetBall();
    }
    if(ball.x + ball.radius > canvas.width){
        playerScore++;
        resetBall();
    }

    document.getElementById('playerScore').textContent = playerScore;
    document.getElementById('aiScore').textContent = aiScore;
}

function resetBall(){
    ball.x = canvas.width/2;
    ball.y = canvas.height/2;
    ball.dx *= -1;
    ball.dy = 4 * (Math.random() > 0.5 ? 1 : -1);
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
