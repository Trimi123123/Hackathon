<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Flappy Bird</title>
<style>
    body {
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: #70c5ce;
        font-family: Arial, sans-serif;
        flex-direction: column;
    }
    canvas {
        background: #70c5ce;
        display: block;
        border: 2px solid #000;
    }
    #resetButton {
        display: none;
        margin-top: 10px;
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
<canvas id="game" width="400" height="600"></canvas>
<div style="position:absolute;top:10px;color:#fff;font-size:20px;">Score: <span id="score">0</span></div>
<button id="resetButton">Reset</button>
<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');
const resetButton = document.getElementById('resetButton');

let bird, pipes, frame, score;

function init(){
    bird = { x: 80, y: 300, width: 30, height: 30, gravity: 0.3, velocity: 0, jump: -7 };
    pipes = [];
    frame = 0;
    score = 0;
    document.getElementById('score').textContent = score;
    resetButton.style.display = 'none';
    update();
}

function drawBird(){
    ctx.fillStyle = 'yellow';
    ctx.fillRect(bird.x, bird.y, bird.width, bird.height);
}

function drawPipes(){
    ctx.fillStyle = 'green';
    pipes.forEach(pipe => {
        ctx.fillRect(pipe.x, 0, 50, pipe.top);
        ctx.fillRect(pipe.x, canvas.height - pipe.bottom, 50, pipe.bottom);
    });
}

function movePipes(){
    pipes.forEach(pipe => pipe.x -= 2);
    if(pipes.length && pipes[0].x + 50 < 0){
        pipes.shift();
        score++;
        document.getElementById('score').textContent = score;
    }
}

function addPipe(){
    let top = Math.random() * (canvas.height - 150 - 100) + 50;
    let bottom = canvas.height - top - 150;
    pipes.push({ x: canvas.width, top: top, bottom: bottom });
}

function collision(){
    if(bird.y + bird.height > canvas.height || bird.y < 0) return true;
    for(let pipe of pipes){
        if(bird.x < pipe.x + 50 && bird.x + bird.width > pipe.x &&
           (bird.y < pipe.top || bird.y + bird.height > canvas.height - pipe.bottom)){
               return true;
           }
    }
    return false;
}

function jump(){
    bird.velocity = bird.jump;
}

function update(){
    ctx.clearRect(0,0,canvas.width,canvas.height);

    bird.velocity += bird.gravity;
    bird.y += bird.velocity;

    if(frame % 100 === 0) addPipe();
    movePipes();

    drawPipes();
    drawBird();

    frame++;

    if(collision()){
        resetButton.style.display = 'block';
        return;
    }

    requestAnimationFrame(update);
}

document.addEventListener('keydown', e => { if(e.key === ' ') jump(); });
document.addEventListener('click', jump);
resetButton.addEventListener('click', init);

init();
</script>
</body>
</html>