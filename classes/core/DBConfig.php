<?php
namespace core;

use PDO;
use PDOException;

class DBConfig {
    private string $host;
    private string $db_name;
    private string $user;
    private string $pass;
    private string $charset;

    private ?PDO $pdo = null;
    private array $options;

    public function __construct(
        string $host = 'localhost',
        string $db_name = '',
        string $user = 'root',
        string $pass = '',
        string $charset = 'utf8mb4'
    ) {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->user = $user;
        $this->pass = $pass;
        $this->charset = $charset;

        $this->options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }

    public function getConnection(): PDO {
        if ($this->pdo === null) {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";

            try {
                $this->pdo = new PDO($dsn, $this->user, $this->pass, $this->options);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage());
            }
        }
        return $this->pdo;
    }

    public function db_check(): bool {
        // controlleer of er al een poging is gedaan
        if (!isset($_SESSION['DBAttempt'])) {
            $_SESSION['DBAttempt'] = true;
        }
        if (!$_SESSION['DBAttempt']) {
            return false;
        }

        // database verbinden
        try {
            $conn = $this->getConnection();
            $conn->query('SELECT 1');
            unset($_SESSION['DBMessage']);
            return true;
        } catch (PDOException $e) {
            $_SESSION['DBMessage'] = $e->getMessage();
            $_SESSION['DBStatus'] = false;
            $_SESSION['DBAttempt'] = false;
            return false;
        }
    }
}
?>
