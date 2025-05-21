<?php
namespace games\rock_paper_scissors;

use core\Game;
use core\Player;

class Rock_paper_scissors extends Game {
    // propperties
    private array $options = ['steen', 'papier', 'schaar'];

    // Constructor
    public function __construct(Player $player, string $title = 'rock_paper_scissors', string $displayTitle = 'Steen <br> Papier <br> Schaar', array $options = ['steen', 'papier', 'schaar']) {
        parent::__construct($title, $displayTitle, $player);
        $this->options = $options;
    }

    // abstracte methode implementaties
    public function getOptions(): array {
        return $this->options;
    }

    public function renderOptionInput(string $option): string {
        $title = $this->getTitle();
        return "<button type='submit' name='player_choice' value='$option'>
                    <img src='./images/svg_icons/$title/$option.svg' alt='$option' />
                    <p>$option</p>
                </button>";
    }

    public function renderFigure(string $option): string {
        $title = $this->getTitle();
        return "<figure class='icon_figure'>
                    <img src='./images/svg_icons/$title/$option.svg' alt='$option' />
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

        // Dynamisch de winnende paren doorgeven aan determineWinner
        $winningPairs = [
            ['steen', 'schaar'],
            ['papier', 'steen'],
            ['schaar', 'papier']
        ];

        $result = $this->determineWinner($playerChoice, $computerChoice, $winningPairs);

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
    protected function determineWinner(string $player, string $computer, array $winningPairs): string {
        if ($player === $computer) {
            return 'gelijkspel';
        }
        foreach ($winningPairs as $pair) {
            if ($pair[0] === $player && $pair[1] === $computer) {
                return 'gewonnen';
            }
        }
        return 'verloren';
    }
}
?>