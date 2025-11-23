<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chase Game with Points</title>
    <style>
        body {
            background: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            flex-direction: column;
        }
        canvas {
            background: #111;
            border: 2px solid #fff;
        }
        h2, p { margin: 5px; }
    </style>
</head>
<body>
<h2>Green = You | Red = Chaser | Yellow = Points</h2>
<p>Use ARROW KEYS to move. Collect points! Game ends if red catches you.</p>
<canvas id="game" width="400" height="400"></canvas>
<div>Score: <span id="score">0</span> | Highscore: <span id="highscore">0</span></div>
<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');

let player = { x: 200, y: 200, size: 10, speed: 15 };
let chaser = { x: 50, y: 50, size: 10, speed: 10 };
let points = [];
let score = 0;
let highscore = parseInt(localStorage.getItem('chase_high')) || 0;

document.getElementById('highscore').textContent = highscore;

// Generate 10 random points
for (let i = 0; i < 10; i++) {
    points.push({ x: Math.random() * 380 + 10, y: Math.random() * 380 + 10, size: 5 });
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // draw points
    ctx.fillStyle = 'yellow';
    points.forEach(p => {
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
        ctx.fill();
    });

    // draw player
    ctx.fillStyle = 'lime';
    ctx.beginPath();
    ctx.arc(player.x, player.y, player.size, 0, Math.PI * 2);
    ctx.fill();

    // draw chaser
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
    // collision with chaser
    let dx = player.x - chaser.x;
    let dy = player.y - chaser.y;
    if (Math.sqrt(dx*dx + dy*dy) < player.size + chaser.size) {
        alert('Game Over! Your score: '+score);
        if(score > highscore){
            localStorage.setItem('chase_high', score);
        }
        location.reload();
    }

    // collision with points
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