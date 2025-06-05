<?php
namespace core;

use core\DBHandler;

class Player {
    // Eigenschappen
    protected string $name;
    protected int $id;
    protected array $scores = [];

    protected bool $db_online = false;

    // Niet serialiseerbaar!
    protected ?DBHandler $dbHandler = null;

    // Constructor
    public function __construct(string $name, int $id = 0, $scores = []) {
        $this->name = $name;
        $this->id = $id;
        $this->scores = $scores;
    }

    // === SERIALISATIE FIX ===
    public function __sleep(): array {
        // Alleen de veilige eigenschappen serialiseren
        return ['name', 'id', 'scores', 'db_online'];
    }

    public function __wakeup(): void {
        // Herstel of reset state (optioneel)
        $this->dbHandler = null;
    }

    // DBHandler setter
    public function setDatabaseHandler(DBHandler $dbHandler): void {
        $this->dbHandler = $dbHandler;
        $this->db_online = $dbHandler->checkConnection();
    }

    // Getters
    public function getName(): string {
        return $this->name;
    }

    public function setScore(string $game_mode, int $score): void {
        $this->scores[$game_mode] = $score;
    }    
    public function getScore(string $gameTitle): int {
        return $this->scores[$gameTitle] ?? 0;
    }

    // Win toevoegen + score bijwerken in DB
    public function addWin(string $gameTitle, int $game_id): void {
        if (!isset($this->scores[$gameTitle])) {
            $this->scores[$gameTitle] = 0;
        }
        $this->scores[$gameTitle]++;

        if ($this->db_online && $this->dbHandler !== null) {
            $player_id = $this->id;
            $new_score = $this->scores[$gameTitle];
            $this->dbHandler->update_score($player_id, $game_id, $new_score);
        }
    }
}
?>