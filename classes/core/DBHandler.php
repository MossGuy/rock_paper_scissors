<?php
namespace core;
use core\DBConfig;
use PDO;
use PDOException;

class DBHandler {
    private DBConfig $config;
    private ?PDO $pdo = null;

    public function __construct(DBConfig $config) {
        $this->pdo = $config->getConnection();
    }

    // nieuwe db_check
    public function getConnection(): PDO {
        if ($this->pdo === null) {
            $this->pdo = $this->config->getConnection();
        }
        return $this->pdo;
    }
    public function checkConnection(): bool {
        try {
            $this->getConnection()->query('SELECT 1');
            return true;
        } catch (PDOException $e) {
            $_SESSION['DBMessage'] = $e->getMessage();
            $_SESSION['DBStatus'] = false;
            return false;
        }
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