<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Allowed games (matches the PHP filenames)
$allowed_games = [
    "snake","tetris","pong","flappy","minesweeper","2048",
    "cookie_clicker","platformer","breakout","pacman","space_invaders",
    "asteroids","angry_birds","fruit_ninja","candy_crush","solitaire",
    "checkers","chess","mahjong","doom","zelda","mario","sonic",
    "frogger","contra","galaga","defender","jump_ball","pinball",
    "arkanoid","lego","runner","shooter","maze","bubble_shooter",
    "fishing","skiing","racing","space_shooter","typing","arcade_fighter"
];

// Get game from URL
$game = $_GET['game'] ?? '';

// Validate game
if (!in_array($game, $allowed_games)) {
    echo "<h2 style='color:white;text-align:center;'>Invalid game selected.</h2>";
    echo "<p style='text-align:center;'><a href='index.php'>Back to Arcade</a></p>";
    exit;
}

// Path to PHP game file
$game_file = "games/{$game}.php";

// Include the PHP game
if (file_exists($game_file)) {
    include($game_file);
} else {
    echo "<h2 style='color:white;text-align:center;'>Game file not found.</h2>";
    echo "<p style='text-align:center;'><a href='index.php'>Back to Arcade</a></p>";
}
?>
