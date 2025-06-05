<?php
namespace core;

use core\Player;
use games\rock_paper_scissors\Rock_paper_scissors;
use games\rock_paper_scissors\Rock_paper_scissors_lizard_spock;
use core\DBConfig;
use core\DBHandler;

class GameHandler {
    public function __construct(DBHandler $dbHandler) {
        $this->dbHandler = $dbHandler;
    }
    public function handleGamePlay($game, $player, $db_online): array {
        if (isset($_POST['player_choice'])) {
            $_SESSION['player_choice'] = $_POST['player_choice'];
            $_SESSION['game_finished'] = true;

            $_SESSION['round_result'] = $game->play($_POST['player_choice'], $db_online);
            $_SESSION['game']['player'] = serialize($player);

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

    public function run(Player $player, string $active_game, $db_online): array {    
        switch ($active_game) {
            case 'rock_paper_scissors':
                $game = new Rock_paper_scissors($player);
                return $this->handleGamePlay($game, $player, $db_online);
    
            case 'rock_paper_scissors_lizard_spock':
                $game = new Rock_paper_scissors_lizard_spock($player);
                return $this->handleGamePlay($game, $player, $db_online);
    
            default:
                return ['error' => 'Game "' . $active_game . '" not found.'];
        }
    }
}
?>