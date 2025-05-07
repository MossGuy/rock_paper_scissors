<?php
session_start();

include_once "./php_functions.php/php_functions.php";

 // de game kan later dymamisch worden opgehaald van de $_SESSION['active_game']
//  game ophalen en valideren
$active_game = "rock_paper_scissors";
$game_available = game_check($active_game);

// classes ophalen
require_once './classes/core/player.php';
require_once 'classes/core/game.php';
require_once 'classes/games/rock_paper_scissors/rock_paper_scissors.php';

use core\Player;
use games\rock_paper_scissors\Rock_paper_scissors;

// game initialiseren
if ($game_available) {
    // Init speler
    if (!isset($_SESSION['player'])) {
        $_SESSION['player'] = serialize(new Player("Speler 1"));
    }
    $player = unserialize($_SESSION['player']);

    // Init game
    $game = new Rock_paper_scissors($player);
}

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
        <section class="game_title <?= !$game_available ? 'unavailable' : '' ?>">
            <h1>Speel een spel</h1>
            <br>
        </section>

        <section class="game_window <?= !$game_available ? 'unavailable' : '' ?>">
            
        </section>

        <section class="<?=$game_available ? 'unavailable' : '' ?>">
            <h2>De game is niet gevonden of word niet ondersteund</h2>
        </section>
    </main>

    <?php include "./web_elements/footer.php"; ?>
</body>
</html>