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
<body></body>