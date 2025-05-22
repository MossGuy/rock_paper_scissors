<?php
require_once './classes/core/player.php';
use core\Player;

define("SUPPORTED_GAMES", ["rock_paper_scissors", "rock_paper_scissors_lizard_spock"]);
function game_check(string $game): bool {
    return in_array($game, SUPPORTED_GAMES);
}

function return_game_session() {
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

    return ['game_playable' => false];
}

if (isset($_POST['change'])) {
    // Controleer of er al een game sessie is
    if (!$game_finished) {
        $current_mode = $_SESSION['game']['game_mode'];
        $_SESSION['game']['game_mode'] = ($current_mode === 'rock_paper_scissors') 
    ? 'rock_paper_scissors_lizard_spock' 
    : 'rock_paper_scissors';
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


if (isset($_POST['reset'])) {
    // TODO: kijk of deze variabelen ook in een versamelnaam opgeslagen kunnen worden
    unset($_SESSION['player_choice'], $_SESSION['game_finished'], $_SESSION['round_result']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// de speler verwijderen uit de lokale session
if (isset($_POST['exit'])) {
    unset($_SESSION['game']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>