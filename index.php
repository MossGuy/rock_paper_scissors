<?php
session_start();

require_once './classes/core/game.php';
require_once './classes/core/player.php';
require_once './classes/core/gameHandler.php';
require_once './classes/core/DBConfig.php';
require_once './classes/core/DBHandler.php';
require_once './classes/games/rock_paper_scissors/rock_paper_scissors.php';
require_once './classes/games/rock_paper_scissors/rock_paper_scissors_lizard_spock.php';
require_once './php_functions/php_functions.php';
require_once './php_functions/isset.php';

use core\GameHandler;
use core\DBConfig;
use core\DBHandler;

// === Database configuratie en handler aanmaken ===
$DBConfig = new DBConfig('127.0.0.1', 'milan_games_db', 'root', '');
$DBHandler = new DBHandler($DBConfig);

$game_session = return_game_session($DBHandler);

$db_online = $DBHandler->db_check();
$db_online_string = $db_online ? 'verbonden' : 'offline';

if (!$game_session['game_playable']) {
    $error_message = $game_session['error'] ?? null;
}
$game_mode = $game_session['game_mode'] ?? null;
$player = $game_session['player'] ?? null;

// === Game-aanspraak via GameHandler ===
$gameHandler = new GameHandler($DBHandler);

if ($game_mode && $player) {
    $player->setDatabaseHandler($DBHandler);
    $game_available = game_check($game_mode);
    if ($game_available) {
        $game_data = $gameHandler->run($player, $game_mode, $db_online);
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
        <!-- Speler gegevens invoeren -->
        <?php if (!$player): ?>
            <section class="player_name_section">
                <form action="" method="post" class="welcome_form flex_column">
                    <input type="hidden" name="db_status" id="db_status" value="<?=$db_online_string?>">
                    <div>
                        <h2>Spelmodus</h2>
                        <br>
                        <select name="game_mode" id="game_mode">
                            <option value="rock_paper_scissors">Steen Papier Schaar</option>
                            <option value="rock_paper_scissors_lizard_spock">Steen Papier Schaar Hagedis Spock</option>
                        </select>
                    </div>
                    <br>

                    <!-- Dynamisch deel op basis van databaseverbinding -->
                    <?php if ($db_online): ?>
                        <div>
                            <h2>Speler login / registratie</h2>
                            <br>
                            <label class="radioItem">
                                <input class="radioButton" type="radio" name="auth_mode" value="login" checked onchange="toggleAuthMode()"> Bestaande speler
                            </label>
                            <label class="radioItem">
                                <input class="radioButton" type="radio" name="auth_mode" value="register" onchange="toggleAuthMode()"> Nieuwe speler
                            </label>
                            <br><br>
                            <div id="auth_fields">
                                <input class="textbox" type="text" id="username" name="username" placeholder="Gebruikersnaam" required>
                                <input class="textbox" type="password" id="password" name="password" placeholder="Wachtwoord" required>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Fallback als geen database is verbonden -->
                        <div>
                            <input class="textbox" type="text" id="player_name" name="player_name" placeholder="Wat is je naam?" required>
                        </div>
                    <?php endif; ?>

                    <br>
                    <input class="button" type="submit" name="go" value="Start het spel">
                </form>
            </section>

            <!-- feedback database -->
            <?php if ($game_session['error'] || !$db_online):?>
                <section>
                    <div class="db_feedback">
                        <?php if (!$db_online): ?>
                            <p class="warning">Database <strong><?= $db_online_string?></strong>.</p>
                        <?php endif; ?>
                        <p class="accent"><?= $game_session['error']??''; ?></p>
                        <br>
                        <?=return_connect_button($db_online)?>
                    </div>
                </section>
            <?php endif;?>
        <?php endif; ?>

        <!-- Game beginnen -->
        <?php if ($game && !$game_finished): ?>
            <section class="game_window">
                <form action="" method="post">
                    <input type="hidden" name="db_status" id="db_status" value="<?=$db_online_string?>">
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