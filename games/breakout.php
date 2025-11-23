<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Breakout Game</title>
<style>
    body { margin:0; overflow:hidden; display:flex; justify-content:center; align-items:center; height:100vh; background:#111; }
    canvas { background:#222; display:block; }
</style>
</head>
<body>
<canvas id="game" width="800" height="600"></canvas>
<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');

// Paddle
const paddle = {
    width: 100,
    height: 15,
    x: canvas.width/2 - 50,
    y: canvas.height - 30,
    speed: 7
};

let rightPressed = false;
let leftPressed = false;

// Ball
const ball = {
    x: canvas.width/2,
    y: canvas.height - 50,
    radius: 10,
    dx: 4,
    dy: -4
};

// Bricks
const brickRowCount = 5;
const brickColumnCount = 8;
const brickWidth = 75;
const brickHeight = 20;
const brickPadding = 10;
const brickOffsetTop = 30;
const brickOffsetLeft = 30;

let bricks = [];
for(let c=0;c<brickColumnCount;c++){
    bricks[c] = [];
    for(let r=0;r<brickRowCount;r++){
        bricks[c][r] = { x:0, y:0, status:1 };
    }
}

let score = 0;
let lives = 3;

function drawBricks(){
    for(let c=0;c<brickColumnCount;c++){
        for(let r=0;r<brickRowCount;r++){
            if(bricks[c][r].status===1){
                let brickX = (c*(brickWidth+brickPadding))+brickOffsetLeft;
                let brickY = (r*(brickHeight+brickPadding))+brickOffsetTop;
                bricks[c][r].x = brickX;
                bricks[c][r].y = brickY;
                ctx.fillStyle='green';
                ctx.fillRect(brickX, brickY, brickWidth, brickHeight);
            }
        }
    }
}

function drawBall(){
    ctx.beginPath();
    ctx.arc(ball.x, ball.y, ball.radius, 0, Math.PI*2);
    ctx.fillStyle='yellow';
    ctx.fill();
    ctx.closePath();
}

function drawPaddle(){
    ctx.fillStyle='white';
    ctx.fillRect(paddle.x, paddle.y, paddle.width, paddle.height);
}

function collisionDetection(){
    for(let c=0;c<brickColumnCount;c++){
        for(let r=0;r<brickRowCount;r++){
            let b = bricks[c][r];
            if(b.status===1){
                if(ball.x > b.x && ball.x < b.x + brickWidth && ball.y > b.y && ball.y < b.y + brickHeight){
                    ball.dy = -ball.dy;
                    b.status = 0;
                    score++;
                    if(score === brickRowCount*brickColumnCount){
                        alert('YOU WIN!');
                        document.location.reload();
                    }
                }
            }
        }
    }
}

function drawScore(){
    ctx.fillStyle='white';
    ctx.font='20px Arial';
    ctx.fillText('Score: ' + score, 10, 20);
}

function drawLives(){
    ctx.fillStyle='white';
    ctx.font='20px Arial';
    ctx.fillText('Lives: ' + lives, canvas.width-100, 20);
}

function draw(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    drawBricks();
    drawBall();
    drawPaddle();
    drawScore();
    drawLives();
    collisionDetection();

    // Ball movement
    ball.x += ball.dx;
    ball.y += ball.dy;

    // Bounce off walls
    if(ball.x + ball.dx > canvas.width-ball.radius || ball.x + ball.dx < ball.radius){
        ball.dx = -ball.dx;
    }
    if(ball.y + ball.dy < ball.radius){
        ball.dy = -ball.dy;
    } else if(ball.y + ball.dy > canvas.height-ball.radius){
        if(ball.x > paddle.x && ball.x < paddle.x + paddle.width){
            ball.dy = -ball.dy;
        } else {
            lives--;
            if(!lives){
                alert('GAME OVER');
                document.location.reload();
            } else {
                ball.x = canvas.width/2;
                ball.y = canvas.height-50;
                ball.dx = 4;
                ball.dy = -4;
                paddle.x = canvas.width/2 - paddle.width/2;
            }
        }
    }

    // Paddle movement
    if(rightPressed && paddle.x < canvas.width - paddle.width){
        paddle.x += paddle.speed;
    } else if(leftPressed && paddle.x > 0){
        paddle.x -= paddle.speed;
    }

    requestAnimationFrame(draw);
}

document.addEventListener('keydown', e=>{
    if(e.key==='ArrowRight') rightPressed=true;
    if(e.key==='ArrowLeft') leftPressed=true;
});
document.addEventListener('keyup', e=>{
    if(e.key==='ArrowRight') rightPressed=false;
    if(e.key==='ArrowLeft') leftPressed=false;
});

draw();
</script>
</body>
</html>