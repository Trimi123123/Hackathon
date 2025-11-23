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
<title>2048 - Quantum Arcade</title>
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
    max-width: 500px;
    margin: 40px auto;
    background-color: #2f2f2f;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.7);
    text-align: center;
}
#game-board {
    display: grid;
    grid-template-columns: repeat(4, 90px);
    grid-template-rows: repeat(4, 90px);
    gap: 10px;
    margin-bottom: 25px;
}
.tile {
    width: 90px;
    height: 90px;
    background-color: #3a3a3a;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 28px;
    font-weight: bold;
    border-radius: 10px;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.5);
    transition: background 0.2s;
}
button {
    padding: 12px 30px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    border-radius: 10px;
    background-color: #3a3a3a;
    color: #fff;
    font-weight: bold;
    box-shadow: 0 6px 15px rgba(0,0,0,0.6);
    transition: background 0.3s, transform 0.2s;
}
button:hover {
    background-color: #4a4a4a;
    transform: translateY(-3px);
}
.back-btn {
    margin-top: 15px;
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
    <h1>2048 - Quantum Arcade</h1>
</header>
<div class="container">
    <div class="score-board">
        Score: <span id="score">0</span>
    </div>
    <div id="game-board"></div>
    <button id="reset">Reset Game</button>
    <div class="back-btn">
        <a href="../index.php">⬅ Back to Arcade</a>
    </div>
</div>

<script>
const boardSize = 4;
let board = [];
let score = 0;
const boardEl = document.getElementById('game-board');
const resetBtn = document.getElementById('reset');
const scoreEl = document.getElementById('score');

function init(){
    board = [];
    boardEl.innerHTML = '';
    score = 0;
    scoreEl.textContent = score;
    for(let i=0;i<boardSize;i++){
        board[i]=[];
        for(let j=0;j<boardSize;j++){
            board[i][j]=0;
            let div = document.createElement('div');
            div.classList.add('tile');
            boardEl.appendChild(div);
        }
    }
    addRandom();
    addRandom();
    draw();
}

function addRandom(){
    let empty = [];
    for(let i=0;i<boardSize;i++){
        for(let j=0;j<boardSize;j++){
            if(board[i][j]===0) empty.push({i,j});
        }
    }
    if(empty.length===0) return;
    let {i,j} = empty[Math.floor(Math.random()*empty.length)];
    board[i][j] = Math.random()<0.9 ? 2 : 4;
}

function draw(){
    let tiles = boardEl.children;
    for(let i=0;i<boardSize;i++){
        for(let j=0;j<boardSize;j++){
            let value = board[i][j];
            let index = i*boardSize + j;
            tiles[index].textContent = value===0?'':value;
            tiles[index].style.backgroundColor = value===0?'#3a3a3a':'#'+(value*123456).toString(16).slice(0,6);
        }
    }
    scoreEl.textContent = score;
}

function slide(row){
    let arr = row.filter(v=>v!==0);
    for(let i=0;i<arr.length-1;i++){
        if(arr[i]===arr[i+1]){
            arr[i]*=2;
            score += arr[i];
            arr[i+1]=0;
        }
    }
    return arr.filter(v=>v!==0).concat(Array(boardSize - arr.filter(v=>v!==0).length).fill(0));
}

function move(dir){
    let rotated=false;
    let moved=false;

    function rotate(){
        let newBoard = [];
        for(let i=0;i<boardSize;i++){
            newBoard[i]=[];
            for(let j=0;j<boardSize;j++){
                newBoard[i][j] = board[j][i];
            }
        }
        board = newBoard;
    }

    switch(dir){
        case 'ArrowUp': rotate(); rotated=true; break;
        case 'ArrowDown': rotate(); board = board.map(r=>r.reverse()); rotated=true; break;
        case 'ArrowRight': board = board.map(r=>r.reverse()); break;
    }

    for(let i=0;i<boardSize;i++){
        let newRow = slide(board[i]);
        if(newRow.toString()!==board[i].toString()) moved=true;
        board[i]=newRow;
    }

    if(rotated){
        board = board[0].map((_,i)=>board.map(row=>row[i]));
        if(dir==='ArrowDown') board = board.map(r=>r.reverse());
    }

    if(dir==='ArrowRight') board = board.map(r=>r.reverse());

    if(moved){
        addRandom();
        draw();
        checkGameOver();
    }
}

function checkGameOver(){
    for(let i=0;i<boardSize;i++){
        for(let j=0;j<boardSize;j++){
            if(board[i][j]===0) return;
            if(i<boardSize-1 && board[i][j]===board[i+1][j]) return;
            if(j<boardSize-1 && board[i][j]===board[i][j+1]) return;
        }
    }
    alert('Game Over! Score: '+score);
}

document.addEventListener('keydown', e => {
    if(['ArrowUp','ArrowDown','ArrowLeft','ArrowRight'].includes(e.key)) move(e.key);
});
resetBtn.addEventListener('click', init);

init();
</script>
</body>
</html>
