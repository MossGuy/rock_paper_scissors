<?php
namespace games\rock_paper_scissors;

use core\Game;
use core\Player;

class Rock_paper_scissors extends Game {
    // propperties
    private array $options = ['steen', 'papier', 'schaar'];

    // constructor
    public function __construct(Player $player) {
        parent::__construct("rock_paper_scissors", "Steen <br> Papier <br> Schaar", $player);
    }

    // getters
    public function return_options() {
        return $this->options;
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
        $winningPairs = [
            ['steen', 'schaar'],
            ['papier', 'steen'],
            ['schaar', 'papier']
        ];
        
        foreach ($winningPairs as [$winner, $loser]) {
            if ($player === $winner && $computer === $loser) return 'gewonnen';
            if ($player === $loser && $computer === $winner) return 'verloren';
        }
        return 'gelijkspel';
    }
}
