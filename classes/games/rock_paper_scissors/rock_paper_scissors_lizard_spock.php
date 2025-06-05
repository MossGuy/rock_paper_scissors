<?php
namespace games\rock_paper_scissors;

use core\Game;
use core\Player;
use games\rock_paper_scissors\Rock_paper_scissors;

class Rock_paper_scissors_lizard_spock extends Rock_paper_scissors {
    protected array $options = ['steen', 'papier', 'schaar', 'hagedis', 'spock'];

    public function __construct(Player $player) {
        parent::__construct($player, 'rock_paper_scissors_lizard_spock', 'Steen <br> Papier <br> Schaar <br> Hagedis <br> Spock', 2, $this->options);
    }
    
    public function play(string $playerChoice): array {;
        $computerChoice = $this->options[array_rand($this->options)];

        // Nieuwe array met winnende paren voor deze variant
        $winningPairs = [
            ['steen', 'schaar'],
            ['papier', 'steen'],
            ['schaar', 'papier'],
            ['steen', 'hagedis'],
            ['hagedis', 'papier'],
            ['papier', 'spock'],
            ['spock', 'schaar'],
            ['schaar', 'hagedis'],
            ['hagedis', 'spock'],
            ['spock', 'steen']
        ];

        $result = $this->determineWinner($playerChoice, $computerChoice, $winningPairs);

        if ($result === "gewonnen") {
            $this->player->addWin($this->title, $this->id);
        }

        return [
            'player' => $playerChoice,
            'computer' => $computerChoice,
            'result' => $result,
            'score' => $this->player->getScore($this->title)
        ];
    }
}
?>