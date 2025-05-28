<?php
 // TODO: bevat hard coded strings
// verander de gamemode 
if (isset($_POST['change'])) {
    // Controleer of er al een game sessie is
    if (!$game_finished) {
        $current_mode = $_SESSION['game']['game_mode'];
        $_SESSION['game']['game_mode'] = ($current_mode === 'rock_paper_scissors') 
    ? 'rock_paper_scissors_lizard_spock' 
    : 'rock_paper_scissors';
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// start een nieuwe game
if (isset($_POST['reset'])) {
    // TODO: kijk of deze variabelen ook in een versamelnaam opgeslagen kunnen worden
    unset($_SESSION['player_choice'], $_SESSION['game_finished'], $_SESSION['round_result']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// de game uit de sessie verwijderen
if (isset($_POST['exit'])) {
    unset($_SESSION['game']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// handmatig opnieuw de database verbinden
if (isset($_POST['db_retry'])) {
    $_SESSION['DBAttempt'] = true;
    header('Refresh:0');
}
?>