-- Verwijder en maak database opnieuw aan
DROP DATABASE IF EXISTS `milan_games_db`;
CREATE DATABASE `milan_games_db`;
USE `milan_games_db`;

-- Tabel: users
CREATE TABLE `users` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabel: games
CREATE TABLE `games` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- Tabel: scores
CREATE TABLE `scores` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    player_id INT NOT NULL,
    game_id INT NOT NULL,
    score INT NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (player_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,

    UNIQUE (player_id, game_id)
);

-- Optioneel: voorbeeldgegevens invoegen
INSERT INTO users (username, password) VALUES 
('testspeler', 'hash456');

INSERT INTO games (name, description) VALUES 
('rock_paper_scissors', 'Standaard versie van steen, papier, schaar.'),
('rock_paper_scissors_lizard_spock', 'Uitgebreide versie volgens The Big Bang Theory.');
