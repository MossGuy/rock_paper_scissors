<?php
namespace games\rock_paper_scissors;

use core\Game;
use core\Player;
use games\rock_paper_scissors\Rock_paper_scissors;

class Rock_paper_scissors_lizard_spock extends Rock_paper_scissors {
    protected array $options = ['steen', 'papier', 'schaar', 'hagedis', 'spock'];

    public function __construct(Player $player) {
        parent::__construct($player, 'rock_paper_scissors_lizard_spock', 'Steen <br> Papier <br> Schaar <br> Hagedis <br> Spock', $this->options);
    }
    

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