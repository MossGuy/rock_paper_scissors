<?php
namespace core;

use core\player;
use games\rock_paper_scissors\Rock_paper_scissors;

class GameHandler {
    public static function run(Player $player, string $active_game): array {
        switch ($active_game) {
            case 'rock_paper_scissors':
                $game = new Rock_paper_scissors($player);
    
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