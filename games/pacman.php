<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pac-Man - Quantum Arcade</title>
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
<h1>🎮 Pac-Man - Quantum Arcade</h1>
</header>

<div class="container">
    <div class="score-board">
        Score: <span id="score">0</span> | Lives: <span id="lives">3</span>
    </div>
    <canvas id="game" width="560" height="620"></canvas>
    <div class="back-btn">
        <a href="../index.php">⬅ Back to Arcade</a>
    </div>
</div>

<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');

const CELL = 20;
const ROWS = 31;
const COLS = 28;

// Maze 0=empty,1=wall,2=dot (simplified)
const MAZE = Array(ROWS).fill(0).map(()=>Array(COLS).fill(2));
for(let r=0;r<ROWS;r++){
    for(let c=0;c<COLS;c++){
        if(r===0||r===ROWS-1||c===0||c===COLS-1) MAZE[r][c]=1;
    }
}

// Player & ghost
let pacman = { x: 14, y: 23, dirX:0, dirY:0, speed:0.15 };
let redGhost = { x:14, y:11, dirX:0, dirY:0, speed:0.12 };

// Game state
let score = 0;
let lives = 3;

// Draw maze
function drawMaze(){
    for(let r=0;r<ROWS;r++){
        for(let c=0;c<COLS;c++){
            if(MAZE[r][c]===1){
                ctx.fillStyle='blue';
                ctx.fillRect(c*CELL,r*CELL,CELL,CELL);
            } else if(MAZE[r][c]===2){
                ctx.fillStyle='yellow';
                ctx.beginPath();
                ctx.arc(c*CELL+CELL/2,r*CELL+CELL/2,3,0,Math.PI*2);
                ctx.fill();
            }
        }
    }
}

// Draw player & ghost
function drawPlayer(){
    ctx.fillStyle='yellow';
    ctx.beginPath();
    ctx.arc(pacman.x*CELL+CELL/2,pacman.y*CELL+CELL/2,CELL/2-2,0,Math.PI*2);
    ctx.fill();
}
function drawGhost(){
    ctx.fillStyle='red';
    ctx.beginPath();
    ctx.arc(redGhost.x*CELL+CELL/2,redGhost.y*CELL+CELL/2,CELL/2-2,0,Math.PI*2);
    ctx.fill();
}

// Move player
function movePlayer(){
    let nextX = pacman.x + pacman.dirX;
    let nextY = pacman.y + pacman.dirY;
    if(MAZE[Math.floor(nextY)][Math.floor(nextX)]!==1){
        pacman.x = nextX;
        pacman.y = nextY;
    }
    if(MAZE[Math.floor(pacman.y)][Math.floor(pacman.x)]===2){
        MAZE[Math.floor(pacman.y)][Math.floor(pacman.x)] = 0;
        score++;
        document.getElementById('score').textContent = score;
    }
}

// Simple red ghost AI
function moveGhost(){
    let dx = pacman.x - redGhost.x;
    let dy = pacman.y - redGhost.y;
    if(Math.abs(dx)>Math.abs(dy)){
        redGhost.dirX = dx>0?redGhost.speed:-redGhost.speed;
        redGhost.dirY=0;
    } else {
        redGhost.dirY = dy>0?redGhost.speed:-redGhost.speed;
        redGhost.dirX=0;
    }
    let nextX = redGhost.x + redGhost.dirX;
    let nextY = redGhost.y + redGhost.dirY;
    if(MAZE[Math.floor(nextY)][Math.floor(nextX)]!==1){
        redGhost.x = nextX;
        redGhost.y = nextY;
    }
    if(Math.floor(redGhost.x)===Math.floor(pacman.x) && Math.floor(redGhost.y)===Math.floor(pacman.y)){
        lives--;
        document.getElementById('lives').textContent=lives;
        if(lives<=0){
            alert('Game Over');
            location.reload();
        } else {
            pacman.x=14; pacman.y=23;
            redGhost.x=14; redGhost.y=11;
        }
    }
}

// Game loop
function gameLoop(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    drawMaze();
    drawPlayer();
    drawGhost();
    movePlayer();
    moveGhost();
    requestAnimationFrame(gameLoop);
}

document.addEventListener('keydown',e=>{
    if(e.key==='ArrowUp'){ pacman.dirX=0; pacman.dirY=-pacman.speed; }
    if(e.key==='ArrowDown'){ pacman.dirX=0; pacman.dirY=pacman.speed; }
    if(e.key==='ArrowLeft'){ pacman.dirX=-pacman.speed; pacman.dirY=0; }
    if(e.key==='ArrowRight'){ pacman.dirX=pacman.speed; pacman.dirY=0; }
});

gameLoop();
</script>
</body>
</html>
