<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<?php include_once("header.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Trim's Quantum Arcade</title>
<style>
    body {
        margin: 0;
        background-color: #1e1e1e;
        color: #e0e0e0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    header {
        background: linear-gradient(90deg, #3a3a3a, #2c2c2c);
        padding: 40px 20px;
        text-align: center;
        color: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.7);
        border-bottom: 2px solid #444;
    }
    header h1 {
        font-size: 3em;
        letter-spacing: 2px;
        margin: 0;
        text-shadow: 1px 1px 5px #000;
    }
    .container {
        padding: 40px 20px;
        max-width: 1400px;
        margin: auto;
    }
    h2 {
        margin-bottom: 30px;
        border-bottom: 2px solid #444;
        padding-bottom: 10px;
        font-size: 2em;
    }
    .game-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 25px;
    }
    .game-card {
        background-color: #2f2f2f;
        padding: 30px;
        text-align: center;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.6);
        transition: transform 0.3s, box-shadow 0.3s;
        font-size: 1.2em;
    }
    .game-card a {
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        display: block;
        font-size: 1.5em;
    }
    .game-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.8);
        background-color: #3a3a3a;
    }
    .logout {
        text-align: center;
        margin: 40px 0;
    }
    .logout a {
        color: #fff;
        text-decoration: none;
        padding: 15px 35px;
        background-color: #2f2f2f;
        border-radius: 10px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.6);
        font-size: 1.2em;
        transition: background-color 0.3s, box-shadow 0.3s;
    }
    .logout a:hover {
        background-color: #3a3a3a;
        box-shadow: 0 8px 20px rgba(0,0,0,0.8);
    }
</style>
</head>
<body>

<header>
    <h1>Quantum Arcade</h1>
</header>

<div class="container">
    <h2>All Games</h2>
    <div class="game-grid">
        <div class="game-card"><a href="games/snake.php">🐍 Snake</a></div>
        <div class="game-card"><a href="games/tetris.php">🧱 Tetris</a></div>
        <div class="game-card"><a href="games/pong.php">🏓 Pong</a></div>
        <div class="game-card"><a href="games/flappy.php">🐤 Flappy Bird</a></div>
        <div class="game-card"><a href="games/minesweeper.php">💣 Minesweeper</a></div>
        <div class="game-card"><a href="games/2048.php">🔢 2048</a></div>
        <div class="game-card"><a href="games/cookie_clicker.php">🍪 Cookie Clicker</a></div>
        <div class="game-card"><a href="games/breakout.php">🏗️ Breakout</a></div>
        <div class="game-card"><a href="games/pacman.php">👻 Pac-Man</a></div>
        <div class="game-card"><a href="games/space_invaders.php">🚀 Space Invaders</a></div>
        <div class="game-card"><a href="games/asteroids.php">🌌 Asteroids</a></div>
    </div>
</div>

<div class="logout">
    <a href="logout.php">Logout</a>
</div>

</body>
</html>