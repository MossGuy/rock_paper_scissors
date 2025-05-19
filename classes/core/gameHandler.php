<?php
namespace core;

use core\player;
use games\rock_paper_scissors\Rock_paper_scissors;
use games\rock_paper_scissors\Rock_paper_scissors_lizard_spock;

class GameHandler {
    public static function run(Player $player, string $active_game): array {
        $gameClass = $classMap[$active_game] ?? Rock_paper_scissors::class;
$game = new $gameClass($player);

// Haal enkel de classnaam zonder namespace
$classParts = explode('\\', get_class($game));
$shortClassName = end($classParts);


//TODO: vraag waarom de switch er zo uit ziet
switch ($shortClassName) {
    case 'Rock_paper_scissors':
    case 'Rock_paper_scissors_lizard_spock':
        if (isset($_POST['player_choice'])) {
            $_SESSION['player_choice'] = $_POST['player_choice'];
            $_SESSION['game_finished'] = true;

            // Resultaat genereren
            $_SESSION['round_result'] = $game->play($_POST['player_choice']);
            $_SESSION['player'] = serialize($player);

            // Redirect
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }

        return [
            'game' => $game,
            'game_finished' => $_SESSION['game_finished'] ?? false,
            'result' => $_SESSION['round_result']['result'] ?? '',
            'player_result' => $_SESSION['round_result']['player'] ?? '',
            'cpu_result' => $_SESSION['round_result']['computer'] ?? '',
        ];
}

        
    
        return [];
    }    
}
?>