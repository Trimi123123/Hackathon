<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Space Invaders</title>
<style>
    body { margin:0; background:#000; display:flex; justify-content:center; align-items:center; height:100vh; }
    canvas { display:block; background:#111; }
</style>
</head>
<body>
<canvas id="game" width="800" height="600"></canvas>
<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');

// Player
const player = { width:50, height:20, x:canvas.width/2-25, y:canvas.height-40, speed:7 };
let rightPressed=false; let leftPressed=false;
let bullets = [];

// Enemies
const enemyRowCount=5; const enemyColumnCount=10;
const enemyWidth=40; const enemyHeight=20; const enemyPadding=10; const enemyOffsetTop=30; const enemyOffsetLeft=30;
let enemies=[];
for(let c=0;c<enemyColumnCount;c++){
    enemies[c]=[];
    for(let r=0;r<enemyRowCount;r++){
        enemies[c][r]={x:0,y:0,status:1};
    }
}

let enemyDx=1; let enemyDy=20;

function drawPlayer(){ ctx.fillStyle='green'; ctx.fillRect(player.x, player.y, player.width, player.height); }
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

let score=0;

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

function collisionDetection(){
    bullets.forEach((b,i)=>{
        for(let c=0;c<enemyColumnCount;c++){
            for(let r=0;r<enemyRowCount;r++){
                let e=enemies[c][r];
                if(e.status===1 && b.x < e.x + enemyWidth && b.x + b.width > e.x && b.y < e.y + enemyHeight && b.y + b.height > e.y){
                    e.status=0; bullets.splice(i,1); score++; if(score===enemyRowCount*enemyColumnCount){ alert('YOU WIN!'); document.location.reload(); }
                }
            }
        }
    });
}

function drawScore(){ ctx.fillStyle='white'; ctx.font='20px Arial'; ctx.fillText('Score: '+score,10,20); }

function updateBullets(){
    bullets.forEach((b,i)=>{ b.y-=5; if(b.y<0) bullets.splice(i,1); });
}

document.addEventListener('keydown', e=>{ if(e.key==='ArrowRight') rightPressed=true; if(e.key==='ArrowLeft') leftPressed=true; if(e.key===' ') bullets.push({x:player.x+player.width/2-2.5,y:player.y,width:5,height:10}); });
document.addEventListener('keyup', e=>{ if(e.key==='ArrowRight') rightPressed=false; if(e.key==='ArrowLeft') leftPressed=false; });

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