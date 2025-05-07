<?php
session_start();
include_once "./php_functions.php/php_functions.php";

 // de game kan later dymamisch worden opgehaald van de $_SESSION['active_game']
//  game ophalen en valideren
$active_game = "rock_paper_scissors";
$game_available = game_check($active_game);

// classes ophalen
require_once 'classes/core/Game.php';
require_once 'classes/core/Player.php';
require_once 'classes/games/rock_paper_scissors/rock_paper_scissors.php';

use core\Player;
use games\rock_paper_scissors\Rock_paper_scissors;

// game afronden en player score updaten


?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="./images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon/favicon-16x16.png">
    <link rel="manifest" href="./images/favicon/site.webmanifest">
    
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
    
    <title>Steen Papier Schaar</title>
</head>
<body>
    <?php include "./web_elements/header.php"; ?>

    <main>
        <section class="game_container">
            <h1>Uitkomst:</h1>
            <p><?php print_r($_POST)?></p>
        </section>
    </main>

    <?php include "./web_elements/footer.php"; ?>
</body>
</html>