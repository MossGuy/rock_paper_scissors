<?php
require_once './classes/core/player.php';
use core\Player;
use core\DBHandler;

define("SUPPORTED_GAMES", ["rock_paper_scissors", "rock_paper_scissors_lizard_spock"]);
function game_check(string $game): bool {
    return in_array($game, SUPPORTED_GAMES);
}

function return_game_session(DBHandler $DBHandler): array {
    // === formulier uitlezen ===
    if (isset($_POST['go'])) {
        $game_mode = $_POST['game_mode'] ?? null;
        $db_status = $_POST['db_status'] ?? 'offline';

        if (!game_check($game_mode)) {
            $_SESSION['game_error'] = 'Ongeldige game mode.';
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }

        // === OFFLINE modus ===
        if ($db_status === 'offline') {
            $player_name = $_POST['player_name'] ?? null;

            if (!$player_name) {
                $_SESSION['game_error'] = 'Vul je naam in.';
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }

            $player = new Player($player_name);
        }

        // === ONLINE modus ===
        elseif ($db_status === 'verbonden') {
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
            $auth_mode = $_POST['auth_mode'] ?? null;

            if (!$username || !$password || !$auth_mode) {
                $_SESSION['game_error'] = 'Vul gebruikersnaam, wachtwoord en modus in.';
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }

            switch ($auth_mode) {
                case 'login':
                    if ($DBHandler->validate_login($username, $password)) {
                        $user_data = $DBHandler->get_user_by_username($username);
                        $player = new Player($user_data['username'], $user_data['id']);
                    } else {
                        $_SESSION['game_error'] = 'De opgegeven inloggegevens zijn incorrect.';
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit;
                    }
                    break;

                case 'register':
                    if ($DBHandler->user_exists($username)) {
                        $_SESSION['game_error'] = 'De opgegeven gebruikersnaam bestaat al.';
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit;
                    }

                    $user_id = $DBHandler->create_user($username, $password);

                    if ($user_id) {
                        $player = new Player($username, $user_id);
                    } else {
                        $_SESSION['game_error'] = 'Registratie mislukt. Probeer het opnieuw.';
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit;
                    }
                    break;

                default:
                    $_SESSION['game_error'] = 'Onbekende fout bij de login/register keuze.';
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
            }
        }

        // === Spel initialiseren in sessie ===
        $_SESSION['game'] = [
            'game_mode' => $game_mode,
            'player' => serialize($player)
        ];

        unset($_SESSION['game_error']); // Vorige fout verwijderen indien van toepassing
        session_write_close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // === Game in sessie aanwezig ===
    if (isset($_SESSION['game'])) {
        $game_mode = $_SESSION['game']['game_mode'];
        $player = unserialize($_SESSION['game']['player']);

        return [
            'game_playable' => true,
            'game_mode' => $game_mode,
            'player' => $player
        ];
    }

    // === Formulier is niet verzonden, toon evt. fout uit sessie ===
    $error = $_SESSION['game_error'] ?? null;
    unset($_SESSION['game_error']); // alleen 1x tonen

    return [
        'game_playable' => false,
        'error' => $error
    ];
}


function return_connect_button($status) {
    if (!$status) {
        // nieuwe poging database verbinden
        return '<form action="" method="post"><input class="button" type="submit" name="db_retry" id="db_retry" value="Verbind het database"></form>';
    } else {
         // TODO: kan eventueel vervangen worden door een disconnect button
        // bij de offline modus $_SESSION['DBMessage'] = "Verbinding handmatig verbroken"
        
        return;
    }
}

?>