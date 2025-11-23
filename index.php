<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Optional: protect page so only logged-in users can access it
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<?php include_once("header.php");?>
<?php

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<header>
    <h1>Trim's Quantum Arcade</h1>
</header>

<div class="welcome">

</div>

<div class="container">
    <h2>Popular Games</h2>
    <div class="game-grid">
        <!-- Original 12 -->
        <div class="game-card"><a href="games/snake.php">🐍 Snake</a></div>
        <div class="game-card"><a href="games/tetris.php">🧱 Tetris</a></div>
        <div class="game-card"><a href="games/pong.php">🏓 Pong</a></div>
        <div class="game-card"><a href="games/flappy.php">🐤 Flappy Bird</a></div>
        <div class="game-card"><a href="games/minesweeper.php">💣 Minesweeper</a></div>
        <div class="game-card"><a href="games/2048.php">🔢 2048</a></div>
        <div class="game-card"><a href="games/cookie_clicker.php">🍪 Cookie Clicker</a></div>
        <div class="game-card"><a href="games/platformer.php">🕹️ Platformer</a></div>
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
