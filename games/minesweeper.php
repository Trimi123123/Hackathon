<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Minesweeper</title>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background: #222;
        color: #fff;
        font-family: Arial, sans-serif;
        flex-direction: column;
    }
    table { border-collapse: collapse; }
    td {
        width: 30px;
        height: 30px;
        text-align: center;
        vertical-align: middle;
        border: 2px solid #555;
        cursor: pointer;
        font-weight: bold;
        user-select: none;
    }
    .mine { background: red; }
    .revealed { background: #999; cursor: default; }
    button { margin-top: 10px; padding: 10px; font-size: 16px; cursor: pointer; }
</style>
</head>
<body>
<h2>Minesweeper</h2>
<div>Flags Left: <span id="flagsLeft"></span></div>
<table id="board"></table>
<button id="reset">Reset Game</button>
<script>
const rows = 10;
const cols = 10;
const minesCount = 15;
let board = [];
let flagsLeft = minesCount;
const boardEl = document.getElementById('board');
const flagsEl = document.getElementById('flagsLeft');
const resetBtn = document.getElementById('reset');

function init(){
    board = [];
    flagsLeft = minesCount;
    flagsEl.textContent = flagsLeft;
    boardEl.innerHTML = '';

    // Create board data
    for(let r=0;r<rows;r++){
        board[r]=[];
        for(let c=0;c<cols;c++){
            board[r][c]={mine:false,revealed:false,flag:false,count:0};
        }
    }

    // Place mines
    let minesPlaced = 0;
    while(minesPlaced < minesCount){
        let r = Math.floor(Math.random()*rows);
        let c = Math.floor(Math.random()*cols);
        if(!board[r][c].mine){
            board[r][c].mine = true;
            minesPlaced++;
        }
    }

    // Calculate neighbor counts
    for(let r=0;r<rows;r++){
        for(let c=0;c<cols;c++){
            if(board[r][c].mine) continue;
            let count = 0;
            for(let dr=-1; dr<=1; dr++){
                for(let dc=-1; dc<=1; dc++){
                    let nr = r+dr;
                    let nc = c+dc;
                    if(nr>=0 && nr<rows && nc>=0 && nc<cols && board[nr][nc].mine) count++;
                }
            }
            board[r][c].count = count;
        }
    }

    // Render table
    for(let r=0;r<rows;r++){
        let tr = document.createElement('tr');
        for(let c=0;c<cols;c++){
            let td = document.createElement('td');
            td.dataset.row = r;
            td.dataset.col = c;
            td.addEventListener('click', revealCell);
            td.addEventListener('contextmenu', flagCell);
            tr.appendChild(td);
        }
        boardEl.appendChild(tr);
    }
}

function revealCell(e){
    let r = parseInt(this.dataset.row);
    let c = parseInt(this.dataset.col);
    let cell = board[r][c];
    if(cell.revealed || cell.flag) return;

    cell.revealed = true;
    this.classList.add('revealed');

    if(cell.mine){
        this.classList.add('mine');
        alert('Game Over!');
        revealAll();
        return;
    }

    if(cell.count>0){
        this.textContent = cell.count;
    } else {
        // Reveal neighbors
        for(let dr=-1; dr<=1; dr++){
            for(let dc=-1; dc<=1; dc++){
                let nr=r+dr; let nc=c+dc;
                if(nr>=0 && nr<rows && nc>=0 && nc<cols && !board[nr][nc].revealed){
                    boardEl.rows[nr].cells[nc].click();
                }
            }
        }
    }

    checkWin();
}

function flagCell(e){
    e.preventDefault();
    let r = parseInt(this.dataset.row);
    let c = parseInt(this.dataset.col);
    let cell = board[r][c];
    if(cell.revealed) return;

    if(cell.flag){
        cell.flag = false;
        this.textContent = '';
        flagsLeft++;
    } else if(flagsLeft>0){
        cell.flag = true;
        this.textContent = '🚩';
        flagsLeft--;
    }
    flagsEl.textContent = flagsLeft;
}

function revealAll(){
    for(let r=0;r<rows;r++){
        for(let c=0;c<cols;c++){
            let cell = board[r][c];
            let td = boardEl.rows[r].cells[c];
            cell.revealed = true;
            td.classList.add('revealed');
            if(cell.mine) td.classList.add('mine');
            if(cell.count>0 && !cell.mine) td.textContent = cell.count;
        }
    }
}

function checkWin(){
    let revealedCount = 0;
    for(let r=0;r<rows;r++){
        for(let c=0;c<cols;c++){
            if(board[r][c].revealed) revealedCount++;
        }
    }
    if(revealedCount === rows*cols - minesCount){
        alert('You Win!');
        revealAll();
    }
}

resetBtn.addEventListener('click', init);
init();
</script>
</body>
</html>
