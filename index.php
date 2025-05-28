<?php
session_start();

require_once './classes/core/game.php';
require_once './classes/core/player.php';
require_once './classes/core/gameHandler.php';
require_once './classes/core/DBConfig.php';
require_once './classes/games/rock_paper_scissors/rock_paper_scissors.php';
require_once './classes/games/rock_paper_scissors/rock_paper_scissors_lizard_spock.php';
require_once './php_functions/php_functions.php';
require_once './php_functions/isset.php';

use core\GameHandler;
use core\DBConfig;

// === Haal de game-sessie op ===
$game_session = return_game_session();

// Als de game niet speelbaar is, haal dan de foutmelding en andere informatie op
if (!$game_session['game_playable']) {
    $error_message = $game_session['error'] ?? null;
    $case = $game_session['case'] ?? null;
}

// Haal de benodigde gegevens uit de game_session
$game_mode = $game_session['game_mode'] ?? null;
$player = $game_session['player'] ?? null;
$case = $game_session['case'] ?? null;

// === Game-aanspraak via GameHandler ===
$game_data = [];
$handler = new GameHandler();
$dbConfig = new DBConfig('127.0.0.1', 'db_games_milan', 'root', '');
$handler->initDatabase($dbConfig);
$db_online = $handler->db_connected;
$db_online_string = $db_online ? 'database verbonden' : 'offline';

if ($game_mode && $player) {
    $game_available = game_check($game_mode);
    if ($game_available) {
        $game_data = $handler->run($player, $game_mode);
    }
}

// === Variabelen voor HTML-output ===
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
    <main class="game_container">
        <!-- Speler naam invoeren -->
        <?php if (!$player): ?>
            <section class="player_name_section">
                <form action="" method="post" class="welcome_form flex_column">
                    <div>
                        <h2>Spelmodus</h2>
                        <br>
                        <select name="game_mode" id="game_mode">
                            <option value="rock_paper_scissors">Steen Papier Schaar</option>
                            <option value="rock_paper_scissors_lizard_spock">Steen Papier Schaar Hagedis Spock</option>
                        </select>
                    </div>
                    <br>
                    <div class="flex_row">
                        <input class="textbox" type="text" id="player_name" name="player_name" placeholder="Wat is je naam?" required>
                        <input class="button" type="submit" name="go" value="Start het spel">
                    </div>
                </form>

                <!-- feedback database -->
                <div class="db_feedback">
                    <p>Database <?=$db_online_string?></p>
                    <br>
                    <?=return_login_button($db_online)?>
                </div>
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
    </main>
    <?php include "./web_elements/footer.php"; ?>
</body>
</html>