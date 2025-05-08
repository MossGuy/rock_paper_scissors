<?php
namespace core;

use core\Player;

abstract class Game {
    // propperties
    protected string $title;
    protected string $displayTitle;
    protected Player $player;

    //constructor
    public function __construct(string $title, string $display_title, Player $player) {
        $this->title = $title;
        $this->displayTitle = $display_title;
        $this->player = $player;
    }

    // getters
    public function getTitle() {
        return $this->title;
    }
    public function getDisplayTitle(): string {
        return $this->displayTitle;
    }

    public function getPlayerScore(): int {
        return $this->player->getScore($this->title);
    }

    // Abstract methods
    abstract public function getOptions(): array;          // Opties voor de game
    abstract public function renderOptionInput(string $option): string; // Renderen van knoppen (inputs)
    abstract public function getRoundResult(): array;      // Uitslag van een ronde

    // Main play method
    abstract public function play(string $playerChoice): array;
}
