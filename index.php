<?php
session_start();

// de game kan later dymamisch worden opgehaald van de $_SESSION['active_game']
$active_game = "rock_paper_scissors";

include_once "./game_logic.php";
game_check($active_game);

// classes ophalen
require_once 'classes/core/Player.php';
require_once 'classes/core/Game.php';
require_once 'classes/games/rock_paper_scissors/rock_paper_scissors.php';

use core\Player;
use games\rock_paper_scissors\rock_paper_scissors;


?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/favicon-32x32.png">
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
    
    <title>Steen Papier Schaar</title>
</head>
<body>
    <?php include "./web_elements/header.php"; ?>

    <main class="game_container">
        <section class="game_title">
            <h1>Speel een spel</h1>
            <br>
        </section>

        <section class="game_window">
        <form action="./game_result.php" method="POST">
            <input class="button" name="player_choice" id="player_choice" type="submit" value="steen">
            <input class="button" name="player_choice" id="player_choice" type="submit" value="papier">
            <input class="button" name="player_choice" id="player_choice" type="submit" value="schaar">
        </form>
        </section>
    </main>

    <?php include "./web_elements/footer.php"; ?>
</body>
</html>