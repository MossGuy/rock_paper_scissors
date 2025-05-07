<?php

define("SUPPORTED_GAMES", ["rock_paper_scissors"]);

function game_check($game) {
    if (!in_array($game, SUPPORTED_GAMES)) {
        die ("Actieve game niet herkend");
    }
}

// game logica voor rock_paper_scissors
if ($active_game === "rock_paper_scissors") {
    // haal de game gegevens en player score op en speel de game

}

?>