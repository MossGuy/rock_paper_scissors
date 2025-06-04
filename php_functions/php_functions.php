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
            return ['game_playable' => false, 'case' => 'formulier', 'error' => 'Ongeldige game mode.'];
        }

        // database offline
        if ($db_status === 'offline') {
            $player_name = $_POST['player_name'] ?? null;

            if (!$player_name) {
                return ['game_playable' => false, 'case' => 'formulier', 'error' => 'Vul je naam in.'];
            }

            // offline player aanmaken zonder wachtwoord
            $player = new Player($player_name);
        }

        // database verbonden
        if ($db_status === 'verbonden') {
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;
            $auth_mode = $_POST['auth_mode'] ?? null;

            if (!$username || !$password || !$auth_mode) {
                return ['game_playable' => false, 'case' => 'formulier', 'error' => 'Vul gebruikersnaam, wachtwoord en modus in.'];
            }

            throw new Exception("Database vervonden pad berijkt. login en nieuwe user functies dienen uitgewerkt te worden.");

            // TODO:
            // === onderscheid maken tussen nieuwe gebruiker en bestaande gebruiker ===
            // --- nieuwe gebruiker aan database toevoegen ---
            // --- player class maken en opslaan in de session ---

            // review code van chatGPT
            // if ($auth_mode === 'login') {
            //     // ongebruikte methode call van chatGPT
            //     $player = $DBHandler->loginPlayer($username, $password);

            //     if (!$player) {
            //         return ['game_playable' => false, 'case' => 'formulier', 'error' => 'Inloggen mislukt.'];
            //     }
            // } elseif ($auth_mode === 'register') {
            //     // ongebruikte methode call van chatGPT
            //     $player = $DBHandler->registerPlayer($username, $password);

            //     if (!$player) {
            //         return ['game_playable' => false, 'case' => 'formulier', 'error' => 'Registratie mislukt.'];
            //     }
            // } else {
            //     return ['game_playable' => false, 'case' => 'formulier', 'error' => 'Ongeldige modus gekozen.'];
            // }
        }

        // Spelerobject opslaan
        $_SESSION['game'] = [
            'game_mode' => $game_mode,
            'player' => serialize($player)
        ];

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // === Game in sessie aanwezig ===
    if (isset($_SESSION['game'])) {
        $game_mode = $_SESSION['game']['game_mode'];
        $player = unserialize($_SESSION['game']['player']);

        return [
            'game_playable' => true,
            'case' => 'ophalen',
            'game_mode' => $game_mode,
            'player' => $player
        ];
    }

    // === game sessie en formulier niet beschikbaar ===
    return ['game_playable' => false];
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