<?php

if (isset($_SESSION['player'])) {
    // haal player gegevels op
} else {
    // vraag de gebruiker om een player name
}

define("SUPPORTED_GAMES", ["rock_paper_scissors"]);
function game_check(string $game): bool {
    return in_array($game, SUPPORTED_GAMES);
}

if (isset($_POST['reset'])) {
    unset($_SESSION['player_choice']);
    unset($_SESSION['game_finished']);
    unset($_SESSION['round_result']);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>