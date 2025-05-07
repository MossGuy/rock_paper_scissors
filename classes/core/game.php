<?php
namespace core;

use core\Player;

abstract class Game {
    // propperties
    protected string $title;
    protected Player $player;

    //constructor
    public function __construct(string $title, Player $player) {
        $this->title = $title;
        $this->player = $player;
    }

    // getters
    public function getTitle(): string {
        return $this->title;
    }

    public function getPlayerScore(): int {
        return $this->player->getScore($this->title);
    }

    // methods
    abstract public function play(string $playerChoice): array;
}
