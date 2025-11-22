<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Trim's Quantum Arcade</title>
<style>
    body {
        margin: 0;
        padding: 0;
        background: #0b0f20;
        font-family: Arial, Helvetica, sans-serif;
        color: #fff;
    }
    header {
        background: #141a33;
        padding: 20px;
        text-align: center;
        border-bottom: 2px solid #20294d;
    }
    header h1 {
        margin: 0;
        font-size: 2.4rem;
        color: #67d2ff;
        text-shadow: 0 0 10px #3aa9ff;
    }
    .welcome {
        text-align: center;
        margin: 20px 0;
        font-size: 1.3rem;
        color: #9dd8ff;
    }
    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
    }
    .game-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
    }
    .game-card {
        background: #1b2347;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        transition: 0.2s;
        border: 1px solid #2a366b;
    }
    .game-card:hover {
        transform: scale(1.05);
        background: #222d59;
        cursor: pointer;
    }
    .game-card a {
        text-decoration: none;
        color: #9dd8ff;
        font-size: 1.1rem;
    }
    .logout {
        text-align: center;
        margin-top: 20px;
    }
    .logout a {
        text-decoration: none;
        color: #ff6b6b;
        font-weight: bold;
    }
</style>
</head>
<body>

<header>
    <h1>Trim's Quantum Arcade</h1>
</header>

<div class="welcome">
    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
</div>

<div class="container">
    <h2>Popular Games</h2>
    <div class="game-grid">
        <!-- Original 12 -->
        <div class="game-card"><a href="games/snake.html">🐍 Snake</a></div>
        <div class="game-card"><a href="games/tetris.html">🧱 Tetris</a></div>
        <div class="game-card"><a href="games/pong.html">🏓 Pong</a></div>
        <div class="game-card"><a href="games/flappy.html">🐤 Flappy Bird</a></div>
        <div class="game-card"><a href="games/minesweeper.html">💣 Minesweeper</a></div>
        <div class="game-card"><a href="games/2048.html">🔢 2048</a></div>
        <div class="game-card"><a href="games/cookie_clicker.html">🍪 Cookie Clicker</a></div>
        <div class="game-card"><a href="games/platformer.html">🕹️ Platformer</a></div>
        <div class="game-card"><a href="games/breakout.html">🏗️ Breakout</a></div>
        <div class="game-card"><a href="games/pacman.html">👻 Pac-Man</a></div>
        <div class="game-card"><a href="games/space_invaders.html">🚀 Space Invaders</a></div>
        <div class="game-card"><a href="games/asteroids.html">🌌 Asteroids</a></div>

        <!-- 28 more games -->
        <div class="game-card"><a href="games/angry_birds.html">🐦 Angry Birds</a></div>
        <div class="game-card"><a href="games/fruit_ninja.html">🍉 Fruit Ninja</a></div>
        <div class="game-card"><a href="games/candy_crush.html">🍭 Candy Crush</a></div>
        <div class="game-card"><a href="games/solitaire.html">🃏 Solitaire</a></div>
        <div class="game-card"><a href="games/checkers.html">♟️ Checkers</a></div>
        <div class="game-card"><a href="games/chess.html">♔ Chess</a></div>
        <div class="game-card"><a href="games/mahjong.html">🀄 Mahjong</a></div>
        <div class="game-card"><a href="games/doom.html">🔫 Doom</a></div>
        <div class="game-card"><a href="games/zelda.html">🗡️ Zelda</a></div>
        <div class="game-card"><a href="games/mario.html">🍄 Mario</a></div>
        <div class="game-card"><a href="games/sonic.html">💨 Sonic</a></div>
        <div class="game-card"><a href="games/frogger.html">🐸 Frogger</a></div>
        <div class="game-card"><a href="games/contra.html">🕹️ Contra</a></div>
        <div class="game-card"><a href="games/galaga.html">👾 Galaga</a></div>
        <div class="game-card"><a href="games/defender.html">🛡️ Defender</a></div>
        <div class="game-card"><a href="games/jump_ball.html">🏀 Jump Ball</a></div>
        <div class="game-card"><a href="games/pinball.html">🎱 Pinball</a></div>
        <div class="game-card"><a href="games/arkanoid.html">🟦 Arkanoid</a></div>
        <div class="game-card"><a href="games/lego.html">🧱 LEGO Builder</a></div>
        <div class="game-card"><a href="games/runner.html">🏃 Endless Runner</a></div>
        <div class="game-card"><a href="games/shooter.html">🔫 Shooter</a></div>
        <div class="game-card"><a href="games/maze.html">🌀 Maze</a></div>
        <div class="game-card"><a href="games/bubble_shooter.html">🔵 Bubble Shooter</a></div>
        <div class="game-card"><a href="games/fishing.html">🎣 Fishing</a></div>
        <div class="game-card"><a href="games/skiing.html">⛷️ Skiing</a></div>
        <div class="game-card"><a href="games/racing.html">🏎️ Racing</a></div>
        <div class="game-card"><a href="games/space_shooter.html">🌠 Space Shooter</a></div>
        <div class="game-card"><a href="games/typing.html">⌨️ Typing Game</a></div>
        <div class="game-card"><a href="games/arcade_fighter.html">🥋 Arcade Fighter</a></div>
    </div>
</div>

<div class="logout">
    <a href="logout.php">Logout</a>
</div>

</body>
</html>
