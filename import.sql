DROP DATABASE IF EXISTS `milan_games_db`;
CREATE DATABASE `milan_games_db`;
USE `milan_games_db`;

CREATE TABLE `users` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `scores` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    player_id INT NOT NULL,
    game_type ENUM('rock_paper_scissors', 'rock_paper_scissors_lizard_spock') NOT NULL,
    score INT NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (player_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE (player_id, game_type)
);
