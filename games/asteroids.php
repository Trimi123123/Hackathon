<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Asteroids - Quantum Arcade</title>
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
    background-color: #111;
    border: 3px solid #444;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.9);
    margin-bottom: 20px;
}

.score-board {
    margin: 15px 0 20px;
    font-size: 1.2em;
    font-weight: bold;
}

.back-btn a, #restartBtn {
    display: inline-block;
    color: #fff;
    text-decoration: none;
    padding: 12px 30px;
    background-color: #3a3a3a;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.6);
    font-weight: bold;
    transition: background 0.3s, transform 0.2s;
    cursor: pointer;
}

.back-btn a:hover, #restartBtn:hover {
    background-color: #4a4a4a;
    transform: translateY(-3px);
}

#restartBtn {
    display: none;
    margin-top: 15px;
}
</style>
</head>
<body>

<header>
    <h1>💫 Asteroids - Quantum Arcade</h1>
</header>

<div class="container">
    <div class="score-board">
        Score: <span id="score">0</span>
    </div>
    <canvas id="game" width="800" height="600"></canvas>
    <div class="back-btn">
        <a href="../index.php">⬅ Back to Arcade</a>
    </div>
    <button id="restartBtn">Restart Game</button>
</div>

<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');
const restartBtn = document.getElementById('restartBtn');

let score = 0;
document.getElementById('score').textContent = score;

class Ship {
    constructor(){
        this.x = canvas.width/2;
        this.y = canvas.height/2;
        this.angle = 0;
        this.radius = 20;
        this.dx = 0;
        this.dy = 0;
        this.speed = 0.2;
    }
    update(){
        this.x += this.dx;
        this.y += this.dy;
        if(this.x < 0) this.x = canvas.width;
        if(this.x > canvas.width) this.x = 0;
        if(this.y < 0) this.y = canvas.height;
        if(this.y > canvas.height) this.y = 0;
        this.dx *= 0.98;
        this.dy *= 0.98;
    }
    draw(){
        ctx.save();
        ctx.translate(this.x, this.y);
        ctx.rotate(this.angle);
        ctx.beginPath();
        ctx.moveTo(0, -this.radius);
        ctx.lineTo(this.radius/2, this.radius);
        ctx.lineTo(-this.radius/2, this.radius);
        ctx.closePath();
        ctx.strokeStyle = 'lime';
        ctx.lineWidth = 3;
        ctx.stroke();
        ctx.restore();
    }
}

class Bullet {
    constructor(x,y,angle){
        this.x=x; this.y=y; this.angle=angle; this.speed=7;
    }
    update(){
        this.x += Math.sin(this.angle)*this.speed;
        this.y -= Math.cos(this.angle)*this.speed;
    }
    draw(){
        ctx.beginPath();
        ctx.arc(this.x,this.y,3,0,Math.PI*2);
        ctx.fillStyle='yellow';
        ctx.fill();
    }
}

class Asteroid {
    constructor(x,y,radius){
        this.x=x; this.y=y; this.radius=radius;
        this.dx=(Math.random()*2-1)*1.5;
        this.dy=(Math.random()*2-1)*1.5;
    }
    update(){
        this.x += this.dx;
        this.y += this.dy;
        if(this.x < 0) this.x = canvas.width;
        if(this.x > canvas.width) this.x = 0;
        if(this.y < 0) this.y = canvas.height;
        if(this.y > canvas.height) this.y = 0;
    }
    draw(){
        ctx.beginPath();
        ctx.arc(this.x,this.y,this.radius,0,Math.PI*2);
        ctx.strokeStyle='red';
        ctx.lineWidth=2;
        ctx.stroke();
    }
}

let ship, bullets, asteroids;
let gameRunning = true;

function initGame(){
    score = 0;
    document.getElementById('score').textContent = score;
    ship = new Ship();
    bullets = [];
    asteroids = [];
    gameRunning = true;
    restartBtn.style.display = 'none';
    for(let i=0;i<6;i++){
        asteroids.push(new Asteroid(Math.random()*canvas.width, Math.random()*canvas.height, 30 + Math.random()*20));
    }
}

function collision(a,b){
    let dx = a.x - b.x;
    let dy = a.y - b.y;
    let distance = Math.sqrt(dx*dx + dy*dy);
    return distance < a.radius + (b.radius || 3);
}

function gameLoop(){
    if(!gameRunning) return;

    ctx.clearRect(0,0,canvas.width,canvas.height);
    ship.update(); ship.draw();
    
    bullets.forEach((b,i)=>{
        b.update(); b.draw();
        if(b.x<0||b.x>canvas.width||b.y<0||b.y>canvas.height) bullets.splice(i,1);
    });

    asteroids.forEach((a,ai)=>{
        a.update(); a.draw();
        if(collision(ship,a)){
            gameRunning = false;
            restartBtn.style.display = 'inline-block';
        }
        bullets.forEach((b,bi)=>{
            if(collision(b,a)){
                bullets.splice(bi,1);
                asteroids.splice(ai,1);
                score += 10;
                document.getElementById('score').textContent = score;
            }
        });
    });

    if(Math.random()<0.005) asteroids.push(new Asteroid(Math.random()*canvas.width, Math.random()*canvas.height, 20 + Math.random()*20));

    requestAnimationFrame(gameLoop);
}

// Controls
document.addEventListener('keydown', e=>{
    if(!gameRunning) return;
    if(e.key==='ArrowLeft') ship.angle -= 0.1;
    if(e.key==='ArrowRight') ship.angle += 0.1;
    if(e.key==='ArrowUp') { ship.dx += Math.sin(ship.angle)*ship.speed; ship.dy -= Math.cos(ship.angle)*ship.speed; }
    if(e.key===' ') bullets.push(new Bullet(ship.x,ship.y,ship.angle));
});

restartBtn.addEventListener('click', ()=>{
    initGame();
    gameLoop();
});

initGame();
gameLoop();
</script>
</body>
</html>
