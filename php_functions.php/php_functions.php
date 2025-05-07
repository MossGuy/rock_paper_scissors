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

?>