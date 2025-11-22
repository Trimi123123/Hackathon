-- Create the database
CREATE DATABASE IF NOT EXISTS Trims_Quantum_Arcade;
USE Trims_Quantum_Arcade;


CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    game VARCHAR(50) NOT NULL,
    score INT DEFAULT 0,
    date_played TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    game VARCHAR(50) NOT NULL,
    achievement_name VARCHAR(100),
    date_unlocked TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);



-- Table for games
CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,  -- ex: "snake", "tetris"
    description TEXT,
    category_id INT,
    game_url VARCHAR(255) NOT NULL,     -- ex: "/games/snake.html"
    thumbnail_url VARCHAR(255),         -- optional game image
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    play_count INT DEFAULT 0,

    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Insert some example categories
INSERT INTO categories (name, description) VALUES
('Arcade Classics', 'Traditional retro-style arcade games'),
('Puzzle', 'Mind-challenging puzzle and logic games'),
('Action', 'Games requiring quick reflexes');

-- Insert example game entries
INSERT INTO games (title, slug, description, category_id, game_url, thumbnail_url)
VALUES
('Snake', 'snake', 'Classic snake game.', 1, '/games/snake.html', '/img/snake.png'),
('Tetris', 'tetris', 'Block stacking puzzle game.', 2, '/games/tetris.html', '/img/tetris.png'),
('Pong', 'pong', 'Retro table tennis arcade game.', 1, '/games/pong.html', '/img/pong.png'),
('Flappy Bird', 'flappy-bird', 'Tap to fly through pipes.', 3, '/games/flappy.html', '/img/flappy.png'),
('Minesweeper', 'minesweeper', 'Avoid hidden mines and clear the grid.', 2, '/games/minesweeper.html', '/img/minesweeper.png'),
('2048', '2048', 'Number merging puzzle game.', 2, '/games/2048.html', '/img/2048.png');
