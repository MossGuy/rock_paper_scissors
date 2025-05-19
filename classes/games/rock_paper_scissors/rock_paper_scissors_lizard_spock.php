<?php
namespace games\rock_paper_scissors;

use core\Game;
use core\Player;

class Rock_paper_scissors_lizard_spock extends Rock_paper_scissors {
    private array $options = ['steen', 'papier', 'schaar', 'lizard', 'spock'];

    // TODO: constructor fixen (originele constructor heeft hard-coded waarden die eruit moeten)
    // public function __construct(Player $player) {
    //     parent::__construct(
    //         "rock_paper_scissors_lizard_spock",   // Spelnaam
    //         "Steen <br> Papier <br> Schaar <br> Hagedis <br> Spock", // Keuzes
    //         $player   // Player object
    //     );
    // }
    

    private function determineWinner(string $player, string $computer): string {
        $winningPairs = [
            ['schaar', 'papier'],
            ['papier', 'steen'],
            ['steen', 'hagedis'],
            ['hagedis', 'spock'],
            ['spock', 'schaar'],
            ['schaar', 'hagedis'],
            ['hagedis', 'papier'],
            ['papier', 'spock'],
            ['spock', 'steen'],
            ['steen', 'schaar']
        ];

        foreach ($winningPairs as [$winner, $loser]) {
            if ($player === $winner && $computer === $loser) return 'gewonnen';
            if ($player === $loser && $computer === $winner) return 'verloren';
        }
        return 'gelijkspel';
    }
}
?>