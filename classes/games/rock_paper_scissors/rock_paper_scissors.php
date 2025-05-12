<?php
namespace games\rock_paper_scissors;

use core\Game;
use core\Player;

class Rock_paper_scissors extends Game {
    // propperties
    private array $options = ['steen', 'papier', 'schaar'];

    // Constructor
    public function __construct(Player $player) {
        parent::__construct("rock_paper_scissors", "Steen <br> Papier <br> Schaar", $player);
    }

    // abstracte methode implementaties
    public function getOptions(): array {
        return $this->options;
    }

    public function renderOptionInput(string $option): string {
        return "<button type='submit' name='player_choice' value='$option'>
                    <img src='./images/svg_icons/rock_paper_scissors/$option.svg' alt='$option' />
                    <p>$option</p>
                </button>";
    }

    public function renderFigure(string $option): string {
        return "<figure class='icon_figure'>
                    <img src='./images/svg_icons/rock_paper_scissors/$option.svg' alt='$option' />
                    <figcaption>$option</figcaption>
                </figure>";
    }

    public function getRoundResult(): array {
        return [
            'player' => $this->player->getScore($this->title),
            'computer' => 0 // cpu score kan eventueel bijgehouden worden, thx chatgpt
        ];
    }

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

    // Bereken en return winnaar als string
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
?>