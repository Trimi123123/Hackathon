<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pac-Man Game with Ghosts</title>
<style>
    body { margin:0; display:flex; justify-content:center; align-items:center; height:100vh; background:#000; }
    canvas { display:block; background:#111; }
</style>
</head>
<body>
<canvas id="game" width="600" height="600"></canvas>
<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');
const tileSize = 30;
const rows = 20;
const cols = 20;
const maze = [];
for(let r=0;r<rows;r++){
    maze[r]=[];
    for(let c=0;c<cols;c++){
        if(r===0 || r===rows-1 || c===0 || c===cols-1){
            maze[r][c]=1;
        } else {
            maze[r][c]=2;
        }
    }
}
for(let i=2;i<rows-2;i+=2){ maze[i][5]=1; maze[i][10]=1; maze[i][15]=1; }

let pacman = { x:1, y:1, dx:0, dy:0, color:'yellow', speed:0.1 };
let score = 0;
let dotsTotal = 0;
for(let r=0;r<rows;r++) for(let c=0;c<cols;c++) if(maze[r][c]===2) dotsTotal++;

let ghosts = [
    {x:cols-2, y:rows-2, color:'red', speed:0.05},
    {x:cols-2, y:1, color:'red', speed:0.05}
];

function drawMaze(){
    for(let r=0;r<rows;r++){
        for(let c=0;c<cols;c++){
            if(maze[r][c]===1){ ctx.fillStyle='blue'; ctx.fillRect(c*tileSize, r*tileSize, tileSize, tileSize); }
            else if(maze[r][c]===2){ ctx.fillStyle='white'; ctx.beginPath(); ctx.arc(c*tileSize+tileSize/2,r*tileSize+tileSize/2,5,0,Math.PI*2); ctx.fill(); }
        }
    }
}

function drawPacman(){
    ctx.fillStyle = pacman.color;
    ctx.beginPath();
    ctx.arc(pacman.x*tileSize+tileSize/2, pacman.y*tileSize+tileSize/2, tileSize/2-2,0,Math.PI*2);
    ctx.fill();
}

function drawGhosts(){
    ghosts.forEach(g=>{
        ctx.fillStyle=g.color;
        ctx.beginPath();
        ctx.arc(g.x*tileSize+tileSize/2, g.y*tileSize+tileSize/2, tileSize/2-2,0,Math.PI*2);
        ctx.fill();
    });
}

function updatePacman(){
    let newX = pacman.x + pacman.dx*pacman.speed;
    let newY = pacman.y + pacman.dy*pacman.speed;
    if(maze[Math.floor(newY)] && maze[Math.floor(newY)][Math.floor(newX)] !== 1){
        pacman.x = newX;
        pacman.y = newY;
        let tileX = Math.floor(pacman.x);
        let tileY = Math.floor(pacman.y);
        if(maze[tileY][tileX]===2){ maze[tileY][tileX]=0; score++; if(score===dotsTotal){ alert('YOU WIN!'); document.location.reload(); }}
    }
}

function updateGhosts(){
    ghosts.forEach(g=>{
        let dx = pacman.x - g.x;
        let dy = pacman.y - g.y;
        if(Math.abs(dx) > Math.abs(dy)) g.x += dx>0? g.speed : -g.speed;
        else g.y += dy>0? g.speed : -g.speed;
        if(Math.floor(g.x)===Math.floor(pacman.x) && Math.floor(g.y)===Math.floor(pacman.y)){
            alert('GAME OVER');
            document.location.reload();
        }
    });
}

document.addEventListener('keydown', e=>{
    if(e.key==='ArrowUp') { pacman.dx=0; pacman.dy=-1; }
    if(e.key==='ArrowDown') { pacman.dx=0; pacman.dy=1; }
    if(e.key==='ArrowLeft') { pacman.dx=-1; pacman.dy=0; }
    if(e.key==='ArrowRight') { pacman.dx=1; pacman.dy=0; }
});

function gameLoop(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    drawMaze();
    drawPacman();
    drawGhosts();
    updatePacman();
    updateGhosts();
    ctx.fillStyle='white';
    ctx.font='20px Arial';
    ctx.fillText('Score: '+score, 10, 20);
    requestAnimationFrame(gameLoop);
}

gameLoop();
</script>
</body>
</html>