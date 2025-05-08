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
    switch($active_game) {
        case 'rock_paper_scissors':
            $game = new Rock_paper_scissors($player);

            if (isset($_SESSION['game_finished']) && !isset($_SESSION['round_result'])) {
                // Speel de ronde slechts één keer
                $_SESSION['round_result'] = $game->play($_SESSION['player_choice']);
            
                // Update de player in sessie met nieuwe score
                $_SESSION['player'] = serialize($player);
            }
    
            if (isset($_POST['player_choice'])) {
                $_SESSION['player_choice'] = $_POST['player_choice'];
                $_SESSION['game_finished'] = true;
    
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
    
            // Huidige spelstatus uit sessie ophalen
            $player_choice = $_SESSION['player_choice'] ?? null;
            $game_finished = $_SESSION['game_finished'] ?? false;

            $result = $_SESSION['round_result']['result']??'';
            
            // game specifieke variabelen (hard coded)
            $player_result = $_SESSION['round_result']['player']??'';
            $cpu_result = $_SESSION['round_result']['computer']??'';
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="./images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon/favicon-16x16.png">
    <link rel="manifest" href="./images/favicon/site.webmanifest">

    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
    
    <title>Steen Papier Schaar</title>
</head>
<body>
    <?php include "./web_elements/header.php"; ?>

    <main class="game_container">
        <!-- Game beginnen -->
        <section class="game_window <?= (!$game_available || $game_finished) ? 'unavailable' : '' ?>">
                <h1>Speel een spel</h1>
                <br>
        
                <form action="" method="post">
                <?php
                // game specifieke functie (hard coded)
                foreach ($game->return_options() as $option) {
                    echo "<input class='button' type='submit' name='player_choice', id='player_choice' value='$option'>";
                }
                ?>
                </form>
        </section>

        <!-- Game afronden -->
        <section class="<?=!$game_finished ? 'unavailable' : '' ?>">
            <h2 class="<?=$result?>"><?=$result?></h2>
            <br>

            <div>
                <p><?=$player->getName() . ": " .  $player_result?></p>
                <p>CPU: <?=$cpu_result?></p>
            </div>
            <br>

            <form action="" method="post">
                <input class="button" type="submit" name="reset" id="reset" value="Nog een keer">
            </form>
        </section>

        <!-- Game niet gevonden -->
        <section class="<?=$game_available ? 'unavailable' : '' ?>">
            <h2>De game is niet gevonden of word niet ondersteund</h2>
        </section>
    </main>

    <?php include "./web_elements/footer.php"; ?>
</body>
</html>