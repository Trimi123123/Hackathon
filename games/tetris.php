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
<title>Tetris - Quantum Arcade</title>
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
    <h1>🟦 Tetris - Quantum Arcade</h1>
</header>
<div class="container">
    <canvas id="game" width="600" height="800"></canvas>
    <div class="back-btn">
        <a href="../index.php">⬅ Back to Arcade</a>
    </div>
</div>
<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');
const blockSize = 40;
const cols = canvas.width / blockSize;
const rows = canvas.height / blockSize;
let board = Array.from({ length: rows }, () => Array(cols).fill(0));
const colors = [null,'#00f0f0','#0000f0','#f0a000','#f0f000','#00f000','#a000f0','#f00000'];
const shapes = [[],
  [[1,1,1,1]],
  [[2,0,0],[2,2,2]],
  [[0,0,3],[3,3,3]],
  [[4,4],[4,4]],
  [[0,5,5],[5,5,0]],
  [[0,6,0],[6,6,6]],
  [[7,7,0],[0,7,7]]
];

function drawBlock(x,y,color){
    ctx.fillStyle=color;
    ctx.fillRect(x*blockSize,y*blockSize,blockSize,blockSize);
    ctx.strokeStyle='#111';
    ctx.strokeRect(x*blockSize,y*blockSize,blockSize,blockSize);
}
function drawBoard(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    board.forEach((row,y)=>{
        row.forEach((value,x)=>{
            if(value){ drawBlock(x,y,colors[value]); }
        });
    });
}
function drawCurrent(){
    current.shape.forEach((row,y)=>{
        row.forEach((value,x)=>{
            if(value){ drawBlock(current.x+x,current.y+y,colors[value]); }
        });
    });
}
function collide(){
    for(let y=0;y<current.shape.length;y++){
        for(let x=0;x<current.shape[y].length;x++){
            if(current.shape[y][x] && (board[y+current.y] && board[y+current.y][x+current.x]) !==0){ return true; }
        }
    }
    return false;
}
function merge(){
    current.shape.forEach((row,y)=>{
        row.forEach((value,x)=>{
            if(value){ board[y+current.y][x+current.x]=value; }
        });
    });
}
function drop(){
    current.y++;
    if(collide()){
        current.y--;
        merge();
        current = {
            shape: shapes[Math.floor(Math.random()*7)+1],
            x: Math.floor(cols/2)-1,
            y:0
        };
    }
}

let current = { shape: shapes[Math.floor(Math.random()*7)+1], x: Math.floor(cols/2)-1, y:0 };

document.addEventListener('keydown', e=>{
    switch(e.key){
        case 'ArrowLeft':
            current.x--;
            if(collide()) current.x++;
            break;
        case 'ArrowRight':
            current.x++;
            if(collide()) current.x--;
            break;
        case 'ArrowDown':
            current.y++;
            if(collide()){
                current.y--;
                merge();
                current = { shape: shapes[Math.floor(Math.random()*7)+1], x: Math.floor(cols/2)-1, y:0 };
            }
            break;
        case 'ArrowUp':
            const prevShape = JSON.parse(JSON.stringify(current.shape));
            current.shape = current.shape[0].map((_,i)=>current.shape.map(row=>row[i]).reverse());
            if(collide()) current.shape = prevShape;
            break;
    }
});

setInterval(()=>{
    drawBoard();
    drawCurrent();
    drop();
},400);
</script>
</body>
</html>
