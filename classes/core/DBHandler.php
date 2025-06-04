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
    public function attemptConnectionIfAllowed(): bool {
        // Sessie-instelling controleren
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
    

    // controlleer de verbinding
    public function checkConnection(): bool {
        return $this->pdo !== null;
    }

    // User methods
    function create_user($username, $password) {
        return;
    }
    function get_user_by_id($id) {
        return;
    }
    function get_user_by_username($username) {
        return;
    }
    function delete_user($id) {
        return;
    }
    function user_exists($username) {
        return;
    }
    function validate_login($username, $password) {
        return;
    }

    // Score methods
    function get_score($user_id, $game_id) {
        return;
    }
    function update_score($user_id, $game_id, $score) {
        return;
    }
    function score_exists($user_id, $game_id) {
        return;
    }

    // Game methods
    function get_all_games() {
        return;
    }
    function get_game_by_id($id) {
        return;
    }

    // Optional auth/session methods
    function logout_user() {
        return;
    }
    function is_logged_in() {
        return;
    }

}

?>