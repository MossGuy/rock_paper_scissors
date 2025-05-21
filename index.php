<?php
session_start();

require_once './classes/core/game.php';
require_once './classes/core/player.php';
require_once './classes/core/gameHandler.php';
require_once './classes/games/rock_paper_scissors/rock_paper_scissors.php';
require_once './classes/games/rock_paper_scissors/rock_paper_scissors_lizard_spock.php';
require_once './php_functions.php/php_functions.php';

use core\GameHandler;

$player = return_player();
$active_game = 'rock_paper_scissors_lizard_spock'; // TODO: ophalen vanuit session
$game_available = game_check($active_game);

// === GAME AANROEP VIA GAMEHANDLER ===
$game_data = [];
if ($game_available && $player) {
    $game_data = GameHandler::run($player, $active_game);
}

// === VARIABELEN VOOR HTML OUTPUT ===
$game = $game_data['game'] ?? null;
$game_finished = $game_data['game_finished'] ?? false;
$result = $game_data['result'] ?? '';
$player_result = $game_data['player_result'] ?? '';
$cpu_result = $game_data['cpu_result'] ?? '';

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
    <!-- <p>Active game vanuit de variabel: <?=$active_game?></p> -->
    <main class="game_container">

        <!-- Speler naam invoeren -->
        <?php if (!$player): ?>
            <section class="player_name_section">
                <form action="" method="post">
                    <h2>Wat is je naam?</h2>
                    <input class="textbox" type="text" id="player_name" name="player_name" required>
                    <!-- TODO: select element voor spelmodus wanneer lizard spock klaar is -->
                    <input class="button" type="submit" value="Start het spel">
                </form>
            </section>
        <?php endif; ?>

        <!-- Game beginnen -->
        <?php if ($game && !$game_finished): ?>
            <section class="game_window">
                <form action="" method="post">
                    <?php foreach ($game->getOptions() as $option): ?>
                        <?= $game->renderOptionInput($option) ?>
                    <?php endforeach; ?>
                </form>
            </section>
        <?php endif; ?>

        <!-- Game afronden -->
        <?php if ($game && $game_finished): ?>
            <section>
                <h2 class="<?= htmlspecialchars($result) ?>"><?= htmlspecialchars($result) ?></h2>
                <br>

                <div class="result_window">
                    <div>
                        <p><?= htmlspecialchars($player->getName()) ?>:</p>
                        <?= $game->renderFigure($player_result) ?>
                    </div>
                    <br>
                    <div>
                        <p>CPU:</p>
                        <?= $game->renderFigure($cpu_result) ?>
                    </div>
                </div>
                <br>

                <form action="" method="post">
                    <input class="button" type="submit" name="reset" id="reset" value="Nog een keer">
                </form>
            </section>
        <?php endif; ?>

        <!-- Game niet gevonden -->
        <?php if (!$game_available): ?>
            <section>
                <h2>De game is niet gevonden of wordt niet ondersteund</h2>
            </section>
        <?php endif; ?>
    </main>
    <?php include "./web_elements/footer.php"; ?>
</body>
</html>