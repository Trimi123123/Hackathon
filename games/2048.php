<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>2048 Game</title>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background: #000;
        color: #fff;
        font-family: Arial, sans-serif;
        flex-direction: column;
    }
    #game-board {
        display: grid;
        grid-template-columns: repeat(4, 100px);
        grid-template-rows: repeat(4, 100px);
        gap: 5px;
        margin-bottom: 20px;
    }
    .tile {
        width: 100px;
        height: 100px;
        background: #333;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 32px;
        font-weight: bold;
        border-radius: 5px;
    }
    #reset {
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        background-color: #fff;
        color: #000;
        font-weight: bold;
    }
</style>
</head>
<body>
<h2>2048</h2>
<div id="game-board"></div>
<button id="reset">Reset Game</button>
<script>
const boardSize = 4;
let board = [];
const boardEl = document.getElementById('game-board');
const resetBtn = document.getElementById('reset');

function init(){
    board = [];
    boardEl.innerHTML = '';
    for(let i=0;i<boardSize;i++){
        board[i] = [];
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
            tiles[index].style.backgroundColor = value===0?'#333':'#'+(value*123456).toString(16).slice(0,6);
        }
    }
}

function slide(row){
    let arr = row.filter(v=>v!==0);
    for(let i=0;i<arr.length-1;i++){
        if(arr[i]===arr[i+1]){
            arr[i]*=2;
            arr[i+1]=0;
        }
    }
    return arr.filter(v=>v!==0).concat(Array(boardSize - arr.filter(v=>v!==0).length).fill(0));
}

function move(dir){
    let rotated = false;
    let moved = false;

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
    alert('Game Over!');
}

document.addEventListener('keydown', e => {
    if(['ArrowUp','ArrowDown','ArrowLeft','ArrowRight'].includes(e.key)) move(e.key);
});
resetBtn.addEventListener('click', init);

init();
</script>
</body>
</html>