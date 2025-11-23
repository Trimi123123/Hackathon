<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Snake - Quantum Arcade</title>

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

.instructions {
    margin-bottom: 15px;
    font-size: 1.1em;
    color: #ccc;
}

.score-board {
    margin: 15px 0 25px;
    font-size: 1.2em;
    font-weight: bold;
}

canvas {
    background-color: #1e1e1e;
    border: 3px solid #444;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.9);
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
    <h1>🐍 Snake Chase - Quantum Arcade</h1>
</header>

<div class="container">

    <div class="instructions">
        Green = You | Red = Chaser | Yellow = Points <br>
        Use ARROW KEYS to move. Avoid the red chaser and collect points!
    </div>

    <div class="score-board">
        Score: <span id="score">0</span> |
        Highscore: <span id="highscore">0</span>
    </div>

    <canvas id="game" width="400" height="400"></canvas>

    <div class="back-btn">
        <a href="../index.php">⬅ Back to Arcade</a>
    </div>
</div>

<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');

let player = { x: 200, y: 200, size: 10, speed: 15 };
let chaser = { x: 50, y: 50, size: 10, speed: 10 };
let points = [];
let score = 0;
let highscore = parseInt(localStorage.getItem('chase_high')) || 0;

document.getElementById('highscore').textContent = highscore;

// Generate points
for (let i = 0; i < 10; i++) {
    points.push({ x: Math.random() * 380 + 10, y: Math.random() * 380 + 10, size: 5 });
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.fillStyle = 'yellow';
    points.forEach(p => {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
        ctx.fill();
    });

    ctx.fillStyle = 'lime';
    ctx.beginPath();
    ctx.arc(player.x, player.y, player.size, 0, Math.PI * 2);
    ctx.fill();

    ctx.fillStyle = 'red';
    ctx.beginPath();
    ctx.arc(chaser.x, chaser.y, chaser.size, 0, Math.PI * 2);
    ctx.fill();

    checkCollision();
}

function moveChaser() {
    if (chaser.x < player.x) chaser.x += chaser.speed;
    if (chaser.x > player.x) chaser.x -= chaser.speed;
    if (chaser.y < player.y) chaser.y += chaser.speed;
    if (chaser.y > player.y) chaser.y -= chaser.speed;
}

function checkCollision() {
    let dx = player.x - chaser.x;
    let dy = player.y - chaser.y;

    if (Math.sqrt(dx*dx + dy*dy) < player.size + chaser.size) {
        alert('Game Over! Your score: ' + score);
        if(score > highscore){
            localStorage.setItem('chase_high', score);
        }
        location.reload();
    }

    points.forEach((p, i) => {
        let pdx = player.x - p.x;
        let pdy = player.y - p.y;
        if(Math.sqrt(pdx*pdx + pdy*pdy) < player.size + p.size){
            score++;
            document.getElementById('score').textContent = score;
            points[i] = { x: Math.random() * 380 + 10, y: Math.random() * 380 + 10, size: 5 };
            if(score > highscore) document.getElementById('highscore').textContent = score;
        }
    });
}

document.addEventListener('keydown', e => {
    switch(e.key){
        case 'ArrowUp': player.y -= player.speed; break;
        case 'ArrowDown': player.y += player.speed; break;
        case 'ArrowLeft': player.x -= player.speed; break;
        case 'ArrowRight': player.x += player.speed; break;
        default: return;
    }
    moveChaser();
    draw();
});

draw();
</script>
</body>
</html>
