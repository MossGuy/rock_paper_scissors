<?php
namespace core;

class Player {
    // propperties
    protected string $name;
    protected array $scores = [];

    // constructor
    public function __construct(string $name) {
        $this->name = $name;
    }

    // getters
    public function getName(): string {
        return $this->name;
    }

    public function getScore(string $gameTitle): int {
        return $this->scores[$gameTitle] ?? 0;
    }

    // setters
    public function addWin(string $gameTitle): void {
        // TODO: score van speler updaten in de database
        if (!isset($this->scores[$gameTitle])) {
            $this->scores[$gameTitle] = 0;
        }
        $this->scores[$gameTitle]++;
    }
}
?>