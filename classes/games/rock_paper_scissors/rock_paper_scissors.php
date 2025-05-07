<?php
namespace games\rock_paper_scissors;

use core\Game;
use core\Player;

class Rock_paper_scissors extends Game {
    // propperties
    private array $options = ['steen', 'papier', 'schaar'];

    // constructor
    public function __construct(Player $player) {
        parent::__construct("Steen <br> Papier <br> Schaar", $player);
    }

    // methods
    public function play(string $playerChoice): array {
        $computerChoice = $this->options[array_rand($this->options)];
        $result = $this->determineWinner($playerChoice, $computerChoice);

        if ($result === "gewonnen") {
            $this->player->addWin($this->title);
        }

        return [
            'player' => $playerChoice,
            'computer' => $computerChoice,
            'result' => $result,
            'score' => $this->player->getScore($this->title)
        ];
    }

    private function determineWinner(string $player, string $computer): string {
        if ($player === $computer) return 'gelijkspel';

        $winningCombos = [
            'steen' => 'schaar',
            'papier' => 'steen',
            'schaar' => 'papier'
        ];

        return ($winningCombos[$player] === $computer) ? 'gewonnen' : 'verloren';
    }
}
