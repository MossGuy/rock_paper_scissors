<?php
namespace core;
use core\DBConfig;
use PDO;
use PDOException;

class DBHandler {
    private DBConfig $config;
    private ?PDO $pdo = null;

    public function __construct(DBConfig $config) {
        $this->config = $config;

        try {
            $this->pdo = $this->config->getConnection();
        } catch (PDOException $e) {
            // Log fout en laat verbinding null
            error_log("Fout bij databaseverbinding: " . $e->getMessage());
            $this->pdo = null;
        }
    }


    // nieuwe db_check
    public function getConnection(): ?PDO {
        // Probeer opnieuw verbinding als er nog geen is
        if ($this->pdo === null) {
            try {
                $this->pdo = $this->config->getConnection();
            } catch (PDOException $e) {
                error_log("Fout bij het opnieuw verbinden met de database: " . $e->getMessage());
                $this->pdo = null;
            }
        }

        return $this->pdo;
    }

    // opnieuw verbinden reguleren
    public function db_check(): bool {
        if (!isset($_SESSION['DBAttempt'])) {
            $_SESSION['DBAttempt'] = true; // standaard: poging toestaan
        }
    
        if (!$_SESSION['DBAttempt']) {
            return false; // gebruiker wil geen (nieuwe) poging
        }
    
        // Poging om verbinding te maken
        try {
            $this->pdo = $this->config->getConnection();
            $this->pdo->query('SELECT 1'); // eenvoudige query om te testen
    
            // Reset sessiestatus bij succes
            unset($_SESSION['DBMessage']);
            $_SESSION['DBStatus'] = true;
            return true;
    
        } catch (PDOException $e) {
            // Fout bij verbinding -> sessie instellen
            $_SESSION['DBMessage'] = $e->getMessage();
            $_SESSION['DBStatus'] = false;
            $_SESSION['DBAttempt'] = false;
            $this->pdo = null;
            return false;
        }
    }
    private function executeQuery(string $sql, array $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    // controlleer de verbinding
    public function checkConnection(): bool {
        return $this->pdo !== null;
    }

    // User methods
    public function create_user(string $username, string $password): ?int {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $this->executeQuery($sql, [$username, $hashedPassword]);
    
        // Controleer of insert gelukt is
        if ($stmt && $stmt->rowCount() === 1) {
            // Haal ID van nieuw record op
            return (int) $this->pdo->lastInsertId();
        }
    
        // Insert mislukt
        return null;
    }
    
    function get_user_by_id($id) {
        // haal waarde op - return aray
        return;
    }
    function get_user_by_username($username) {
        // haal waarde op - return aray
        return;
    }
    function delete_user($id) {
        // bewerk database - return bool
        return;
    }
    function user_exists($username) {
        // haal waarde op - return bool
        return;
    }
    function validate_login($username, $password) {
        // haal waarde op en vergelijk met inputs - return bool
        return;
    }

    // Score methods
    function get_score($user_id, $game_id) {
        // haal waarde op - return int
        return;
    }
    function update_score($user_id, $game_id, $score) {
        // bewerk database - return bool
        return;
    }
    function score_exists($user_id, $game_id) {
        // haal waarde op - return bool
        return;
    }

    // Game methods
    function get_all_games() {
        // haal waarde op - return aray
        return;
    }
    function get_game_by_id($id) {
        // haal waarde op - return string
        return;
    }

}

?>