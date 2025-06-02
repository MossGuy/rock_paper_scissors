<?php
require_once './classes/core/player.php';
use core\Player;

define("SUPPORTED_GAMES", ["rock_paper_scissors", "rock_paper_scissors_lizard_spock"]);
function game_check(string $game): bool {
    return in_array($game, SUPPORTED_GAMES);
}

function return_game_session() {
    // formulier uitlezen
    if (isset($_POST['go'])) {
        $game_mode = $_POST['game_mode'] ?? null;
        $player_name = $_POST['player_name'] ?? null;

        if (!$game_mode || !$player_name) {
            return ['game_playable' => false, 'case' => 'formulier', 'error' => 'Vul alle velden in.'];
        }
        if (!game_check($game_mode)) {
            return ['game_playable' => false, 'case' => 'formulier', 'error' => 'Ongeldige game mode.'];
        }

        $player = new Player($player_name);
        $_SESSION['game'] = [
            'game_mode' => $game_mode,
            'player' => serialize($player)
        ];

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // game sessie uitlezen
    if (isset($_SESSION['game'])) {
        $game_mode = $_SESSION['game']['game_mode'];
        $player = unserialize($_SESSION['game']['player']);

        return [
            'game_playable' => true,
            'case' => 'ophalen',
            'game_mode' => $game_mode,
            'player' => $player
        ];
    }

    // formulier en game sessie niet aanwezig
    return ['game_playable' => false];
}

function return_connect_button($status) {
    if (!$status) {
        // nieuwe poging database verbinden
        return '<form action="" method="post"><input class="button" type="submit" name="db_retry" id="db_retry" value="Verbind het database"></form>';
    } else {
         // TODO: kan eventueel vervangen worden door een disconnect button
        // bij de offline modus $_SESSION['DBMessage'] = "Verbinding handmatig verbroken"
        
        return;
    }
}

?>