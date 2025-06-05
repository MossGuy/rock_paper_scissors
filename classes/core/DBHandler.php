<?php
namespace core;
use core\DBConfig;
use PDO;
use PDOException;

class DBHandler {
    private DBConfig $config;
    private ?PDO $pdo = null;

    // === Database verbinden ===
    public function __construct(DBConfig $config) {
        $this->config = $config;

        try {
            $this->pdo = $this->config->getConnection();
        } catch (PDOException $e) {
            error_log("Fout bij databaseverbinding: " . $e->getMessage());
            $this->pdo = null;
        }
    }

    public function getConnection(): ?PDO {
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

    public function db_check(): bool {
        if (!isset($_SESSION['DBAttempt'])) {
            $_SESSION['DBAttempt'] = true;
        }

        if (!$_SESSION['DBAttempt']) {
            return false;
        }

        try {
            $this->pdo = $this->config->getConnection();
            $this->pdo->query('SELECT 1');
            unset($_SESSION['DBMessage']);
            $_SESSION['DBStatus'] = true;
            return true;

        } catch (PDOException $e) {
            $_SESSION['DBMessage'] = $e->getMessage();
            $_SESSION['DBStatus'] = false;
            $_SESSION['DBAttempt'] = false;
            $this->pdo = null;
            return false;
        }
    }

    public function checkConnection(): bool {
        return $this->pdo !== null;
    }

    private function executeQuery(string $sql, array $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // === User Queries ===
    public function create_user(string $username, string $password): ?int {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $this->executeQuery($sql, [$username, $hashedPassword]);

        if ($stmt && $stmt->rowCount() === 1) {
            return (int) $this->pdo->lastInsertId();
        }
        return null;
    }

    public function get_user_by_id($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->executeQuery($sql, [$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_user_by_username($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->executeQuery($sql, [$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete_user($id): bool {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->executeQuery($sql, [$id]);
        return $stmt->rowCount() > 0;
    }

    public function user_exists($username): bool {
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = $this->executeQuery($sql, [$username]);
        return $stmt->rowCount() > 0;
    }

    public function validate_login($username, $password): bool {
        $user = $this->get_user_by_username($username);
        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    }

    // === Score Queries ===
    public function get_score($user_id, $game_id): ?int {
        $sql = "SELECT score FROM scores WHERE player_id = ? AND game_id = ?";
        $stmt = $this->executeQuery($sql, [$user_id, $game_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['score'] : null;
    }

    public function update_score($user_id, $game_id, $new_score): bool {
        if ($this->score_exists($user_id, $game_id)) {
            // Update bestaande score
            $sql = "UPDATE scores SET score = ? WHERE player_id = ? AND game_id = ?";
            $stmt = $this->executeQuery($sql, [$new_score, $user_id, $game_id]);
            return $stmt->rowCount() > 0;
        } else {
            // Insert nieuwe score
            $sql = "INSERT INTO scores (player_id, game_id, score) VALUES (?, ?, ?)";
            $stmt = $this->executeQuery($sql, [$user_id, $game_id, $new_score]);
            return $stmt->rowCount() > 0;
        }
    }

    public function score_exists($user_id, $game_id): bool {
        $sql = "SELECT id FROM scores WHERE player_id = ? AND game_id = ?";
        $stmt = $this->executeQuery($sql, [$user_id, $game_id]);
        return $stmt->rowCount() > 0;
    }

    // === Game Queries ===
    public function get_all_games(): array {
        $sql = "SELECT * FROM games";
        $stmt = $this->executeQuery($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_game_by_id($id): ?string {
        $sql = "SELECT name FROM games WHERE id = ?";
        $stmt = $this->executeQuery($sql, [$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['name'] : null;
    }
}
?>