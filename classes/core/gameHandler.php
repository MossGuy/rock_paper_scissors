<?php
namespace core;

use core\Player;
use games\rock_paper_scissors\Rock_paper_scissors;
use games\rock_paper_scissors\Rock_paper_scissors_lizard_spock;

class GameHandler {
    public function handleGamePlay($game, $player): array {
        // Controleer of de player_choice is ingesteld
        if (isset($_POST['player_choice'])) {
            $_SESSION['player_choice'] = $_POST['player_choice'];
            $_SESSION['game_finished'] = true;

            // Resultaat genereren
            $_SESSION['round_result'] = $game->play($_POST['player_choice']);
            $_SESSION['game']['player'] = serialize($player);

            // Redirect naar dezelfde pagina
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

    public static function run(Player $player, string $active_game): array {
        $handler = new self();  // Maak een instantie van GameHandler

        switch ($active_game) {
            case 'rock_paper_scissors':
                $game = new Rock_paper_scissors($player);
                return $handler->handleGamePlay($game, $player);
        
            case 'rock_paper_scissors_lizard_spock':
                $game = new Rock_paper_scissors_lizard_spock($player);
                return $handler->handleGamePlay($game, $player);

            // Default case voor als geen game wordt gevonden
            default:
                return ['error' => 'Game "' . $active_game . '" not found.'];
        }
    }
}
?>