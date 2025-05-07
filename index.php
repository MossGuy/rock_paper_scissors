<?php session_start();?>
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

    <main class="game_window">
        <h1>Speel een spel</h1>
        <br>
        <form action="./game_result.php" method="POST">
            <input class="button" name="player_choice" id="player_choice" type="submit" value="steen">
            <input class="button" name="player_choice" id="player_choice" type="submit" value="papier">
            <input class="button" name="player_choice" id="player_choice" type="submit" value="schaar">
        </form>
    </main>

    <?php include "./web_elements/footer.php"; ?>
</body>
</html>