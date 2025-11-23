<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Asteroids Game</title>
<style>
    body { margin:0; background:#000; display:flex; justify-content:center; align-items:center; height:100vh; }
    canvas { background:#111; display:block; }
</style>
</head>
<body>
<canvas id="game" width="800" height="600"></canvas>
<script>
const canvas = document.getElementById('game');
const ctx = canvas.getContext('2d');

class Ship {
    constructor(){ this.x=canvas.width/2; this.y=canvas.height/2; this.angle=0; this.radius=15; this.speed=0; this.dx=0; this.dy=0; }
    update(){
        this.x+=this.dx; this.y+=this.dy;
        if(this.x<0) this.x=canvas.width;
        if(this.x>canvas.width) this.x=0;
        if(this.y<0) this.y=canvas.height;
        if(this.y>canvas.height) this.y=0;
    }
    draw(){
        ctx.save(); ctx.translate(this.x,this.y); ctx.rotate(this.angle);
        ctx.beginPath(); ctx.moveTo(0,-this.radius); ctx.lineTo(this.radius/2,this.radius); ctx.lineTo(-this.radius/2,this.radius); ctx.closePath();
        ctx.strokeStyle='white'; ctx.stroke(); ctx.restore();
    }
}

class Bullet {
    constructor(x,y,angle){ this.x=x; this.y=y; this.angle=angle; this.speed=7; }
    update(){ this.x+=Math.sin(this.angle)*this.speed; this.y-=Math.cos(this.angle)*this.speed; }
    draw(){ ctx.beginPath(); ctx.arc(this.x,this.y,2,0,Math.PI*2); ctx.fillStyle='yellow'; ctx.fill(); }
}

class Asteroid {
    constructor(x,y,radius){ this.x=x; this.y=y; this.radius=radius; this.dx=Math.random()*2-1; this.dy=Math.random()*2-1; }
    update(){ this.x+=this.dx; this.y+=this.dy;
        if(this.x<0) this.x=canvas.width; if(this.x>canvas.width) this.x=0;
        if(this.y<0) this.y=canvas.height; if(this.y>canvas.height) this.y=0;
    }
    draw(){ ctx.beginPath(); ctx.arc(this.x,this.y,this.radius,0,Math.PI*2); ctx.strokeStyle='red'; ctx.stroke(); }
}

let ship = new Ship();
let bullets = [];
let asteroids = [];
for(let i=0;i<5;i++) asteroids.push(new Asteroid(Math.random()*canvas.width,Math.random()*canvas.height,30));

function gameLoop(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    ship.draw(); ship.update();
    bullets.forEach((b,i)=>{ b.update(); b.draw(); if(b.x<0||b.x>canvas.width||b.y<0||b.y>canvas.height) bullets.splice(i,1); });
    asteroids.forEach(a=>{ a.update(); a.draw(); });
    requestAnimationFrame(gameLoop);
}

document.addEventListener('keydown', e=>{
    if(e.key==='ArrowLeft') ship.angle -=0.1;
    if(e.key==='ArrowRight') ship.angle +=0.1;
    if(e.key==='ArrowUp') { ship.dx+=Math.sin(ship.angle)*0.2; ship.dy-=Math.cos(ship.angle)*0.2; }
    if(e.key===' ') bullets.push(new Bullet(ship.x,ship.y,ship.angle));
});

gameLoop();
</script>
</body>
</html>