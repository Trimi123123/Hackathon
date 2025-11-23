<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Space Invaders - Quantum Arcade</title>
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
}

.score-board {
    margin: 15px 0 25px;
    font-size: 1.2em;
    font-weight: bold;
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
    <h1>🚀 Space Invaders - Quantum Arcade</h1>
</header>

<div class="container">
    <div class="score-board">
        Score: <span id="score">0</span>
    </div>
    <canvas id="game" width="800" height="600"></canvas>
    <div class="back-btn">
        <a href="../index.php">⬅ Back to Arcade</a>
    </div>
</div>

<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');

// Player
const player = { width:50, height:20, x:canvas.width/2-25, y:canvas.height-40, speed:7 };
let rightPressed=false, leftPressed=false;
let bullets = [];

// Enemies
const enemyRowCount=5, enemyColumnCount=10;
const enemyWidth=40, enemyHeight=20, enemyPadding=10, enemyOffsetTop=30, enemyOffsetLeft=30;
let enemies=[];

for(let c=0;c<enemyColumnCount;c++){
    enemies[c]=[];
    for(let r=0;r<enemyRowCount;r++){
        enemies[c][r]={x:0,y:0,status:1};
    }
}

let enemyDx=1, enemyDy=20;
let score=0;

// Draw functions
function drawPlayer(){ ctx.fillStyle='lime'; ctx.fillRect(player.x, player.y, player.width, player.height); }
function drawBullets(){ bullets.forEach(b=>{ ctx.fillStyle='yellow'; ctx.fillRect(b.x,b.y,b.width,b.height); }); }
function drawEnemies(){
    for(let c=0;c<enemyColumnCount;c++){
        for(let r=0;r<enemyRowCount;r++){
            if(enemies[c][r].status===1){
                let enemyX=c*(enemyWidth+enemyPadding)+enemyOffsetLeft;
                let enemyY=r*(enemyHeight+enemyPadding)+enemyOffsetTop;
                enemies[c][r].x=enemyX; enemies[c][r].y=enemyY;
                ctx.fillStyle='red'; ctx.fillRect(enemyX,enemyY,enemyWidth,enemyHeight);
            }
        }
    }
}

function drawScore(){ ctx.fillStyle='white'; ctx.font='20px Arial'; ctx.fillText('Score: '+score,10,25); }

// Enemy movement
function moveEnemies(){
    let edgeHit=false;
    for(let c=0;c<enemyColumnCount;c++){
        for(let r=0;r<enemyRowCount;r++){
            let e=enemies[c][r];
            if(e.status===1){
                if(e.x + enemyWidth + enemyDx > canvas.width || e.x + enemyDx < 0){ edgeHit=true; }
            }
        }
    }
    if(edgeHit){ enemyDx*=-1; for(let c=0;c<enemyColumnCount;c++) for(let r=0;r<enemyRowCount;r++) if(enemies[c][r].status===1) enemies[c][r].y+=enemyDy; }
    else for(let c=0;c<enemyColumnCount;c++) for(let r=0;r<enemyRowCount;r++) if(enemies[c][r].status===1) enemies[c][r].x+=enemyDx;
}

// Bullet collision detection (fixed: bullet hits only one enemy)
function collisionDetection(){
    bullets.forEach((b,i)=>{
        for(let c=0;c<enemyColumnCount;c++){
            for(let r=0;r<enemyRowCount;r++){
                let e = enemies[c][r];
                if(e.status===1 && b.x < e.x + enemyWidth &&
                   b.x + b.width > e.x &&
                   b.y < e.y + enemyHeight &&
                   b.y + b.height > e.y){
                    e.status = 0;          // Destroy enemy
                    bullets.splice(i,1);   // Remove bullet
                    score++;
                    document.getElementById('score').textContent = score;
                    return;                // Exit bullet loop immediately
                }
            }
        }
    });
}

// Bullet update
function updateBullets(){ bullets.forEach((b,i)=>{ b.y-=5; if(b.y<0) bullets.splice(i,1); }); }

// Key controls
document.addEventListener('keydown', e=>{
    if(e.key==='ArrowRight') rightPressed=true;
    if(e.key==='ArrowLeft') leftPressed=true;
    if(e.key===' ') bullets.push({x:player.x+player.width/2-2.5,y:player.y,width:5,height:10});
});
document.addEventListener('keyup', e=>{
    if(e.key==='ArrowRight') rightPressed=false;
    if(e.key==='ArrowLeft') leftPressed=false;
});

// Game loop
function gameLoop(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    drawPlayer(); drawBullets(); drawEnemies(); drawScore();

    if(rightPressed && player.x < canvas.width-player.width) player.x+=player.speed;
    if(leftPressed && player.x >0) player.x-=player.speed;

    updateBullets(); moveEnemies(); collisionDetection();
    requestAnimationFrame(gameLoop);
}

gameLoop();
</script>
</body>
</html>
