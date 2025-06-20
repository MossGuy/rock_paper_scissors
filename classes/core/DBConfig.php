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
}
?>
