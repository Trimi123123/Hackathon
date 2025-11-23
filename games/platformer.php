<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Platformer Game</title>
<style>
    body { margin:0; overflow:hidden; background:#111; display:flex; justify-content:center; align-items:center; height:100vh; }
    canvas { background:#222; display:block; }
</style>
</head>
<body>
<canvas id="game" width="800" height="400"></canvas>
<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');

const gravity = 0.5;
const keys = {};

class Player {
    constructor(){
        this.width = 30;
        this.height = 50;
        this.x = 50;
        this.y = canvas.height - this.height - 10;
        this.velocityX = 0;
        this.velocityY = 0;
        this.speed = 5;
        this.jumpStrength = -12;
    }
    update(){
        this.velocityY += gravity;
        this.y += this.velocityY;
        this.x += this.velocityX;

        // Collision with ground
        if(this.y + this.height > canvas.height){
            this.y = canvas.height - this.height;
            this.velocityY = 0;
        }

        // Collision with walls
        if(this.x < 0) this.x = 0;
        if(this.x + this.width > canvas.width) this.x = canvas.width - this.width;

        this.draw();
    }
    draw(){
        ctx.fillStyle='yellow';
        ctx.fillRect(this.x,this.y,this.width,this.height);
    }
}

class Platform {
    constructor(x,y,width,height){
        this.x=x; this.y=y; this.width=width; this.height=height;
    }
    draw(){
        ctx.fillStyle='green';
        ctx.fillRect(this.x,this.y,this.width,this.height);
    }
}

const player = new Player();
const platforms = [
    new Platform(0, canvas.height-10, canvas.width, 10),
    new Platform(200, 300, 100, 10),
    new Platform(400, 250, 120, 10),
    new Platform(600, 200, 100, 10)
];

function handlePlatforms(){
    for(let plat of platforms){
        if(player.x + player.width > plat.x && player.x < plat.x + plat.width &&
           player.y + player.height > plat.y && player.y + player.height < plat.y + plat.height + player.velocityY){
            player.y = plat.y - player.height;
            player.velocityY = 0;
        }
    }
}

function gameLoop(){
    ctx.clearRect(0,0,canvas.width,canvas.height);

    platforms.forEach(p=>p.draw());
    player.update();
    handlePlatforms();

    requestAnimationFrame(gameLoop);
}

document.addEventListener('keydown', e => {
    if(e.key === 'ArrowLeft') player.velocityX = -player.speed;
    if(e.key === 'ArrowRight') player.velocityX = player.speed;
    if(e.key === 'ArrowUp') player.velocityY = player.jumpStrength;
});
document.addEventListener('keyup', e => {
    if(e.key === 'ArrowLeft' || e.key === 'ArrowRight') player.velocityX = 0;
});

gameLoop();
</script>
</body>
</html>