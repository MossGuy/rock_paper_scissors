<?php
require_once './classes/core/player.php';
use core\Player;
function return_player(): ?Player {
    if (!isset($_SESSION['player'])) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['player_name'])) {
            $player = new Player($_POST['player_name']);
            $_SESSION['player'] = serialize($player);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
        return null; // Nog geen speler ingesteld
    }

    return unserialize($_SESSION['player']);
}

define("SUPPORTED_GAMES", ["rock_paper_scissors"]);
function game_check(string $game): bool {
    return in_array($game, SUPPORTED_GAMES);
}

if (isset($_POST['reset'])) {
    unset($_SESSION['player_choice'], $_SESSION['game_finished'], $_SESSION['round_result']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>