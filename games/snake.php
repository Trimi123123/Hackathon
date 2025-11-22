<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.html"); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Snake</title>
<style>
    body { background: #0b0f20; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    canvas { background: #111; display: block; }
    a { position: absolute; top: 10px; left: 10px; color: #ff6b6b; text-decoration: none; font-weight: bold; }
</style>
</head>
<body>
<a href="../index.php">Back to Arcade</a>
<canvas id="gameCanvas" width="400" height="400"></canvas>
<script>
const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");

const box = 20;
let snake = [{x: 8*box, y: 8*box}];
let direction = "RIGHT";
let food = {x: Math.floor(Math.random()*20)*box, y: Math.floor(Math.random()*20)*box};
let score = 0;

document.addEventListener("keydown", changeDirection);

function changeDirection(event) {
    if(event.keyCode == 37 && direction != "RIGHT") direction = "LEFT";
    else if(event.keyCode == 38 && direction != "DOWN") direction = "UP";
    else if(event.keyCode == 39 && direction != "LEFT") direction = "RIGHT";
    else if(event.keyCode == 40 && direction != "UP") direction = "DOWN";
}

function draw() {
    ctx.fillStyle = "#111";
    ctx.fillRect(0,0,canvas.width,canvas.height);

    for(let i=0;i<snake.length;i++){
        ctx.fillStyle = (i==0)?"#0f0":"#0a0";
        ctx.fillRect(snake[i].x,snake[i].y,box,box);
    }

    ctx.fillStyle = "#f00";
    ctx.fillRect(food.x,food.y,box,box);

    let snakeX = snake[0].x;
    let snakeY = snake[0].y;

    if(direction=="LEFT") snakeX -= box;
    if(direction=="UP") snakeY -= box;
    if(direction=="RIGHT") snakeX += box;
    if(direction=="DOWN") snakeY += box;

    if(snakeX == food.x && snakeY == food.y){
        score++;
        food = {x: Math.floor(Math.random()*20)*box, y: Math.floor(Math.random()*20)*box};
    } else { snake.pop(); }

    let newHead = {x: snakeX, y: snakeY};

    for(let i=0;i<snake.length;i++){
        if(snake[i].x==newHead.x && snake[i].y==newHead.y){
            clearInterval(game);
            alert("Game Over! Score: "+score);
        }
    }

    if(newHead.x < 0 || newHead.y < 0 || newHead.x >= canvas.width || newHead.y >= canvas.height){
        clearInterval(game);
        alert("Game Over! Score: "+score);
    }

    snake.unshift(newHead);
}

let game = setInterval(draw, 100);
</script>
</body>
</html>
