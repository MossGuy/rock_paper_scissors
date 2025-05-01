<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/favicon-32x32.png">
    <link rel="stylesheet" href="./style.css">
    <script src="./script.js" defer></script>
    
    <title>Steen Papier Schaar</title>
</head>
<body>
    <header>
        <section>
            <h2>steen</h2>
            <h2>papier</h2>
            <h2>schaar</h2>
        </section>
        <section class="score_window">
            <p>score</p>
            <p id="score"></p>
        </section>
    </header>

    <main class="game_window">
        <h1>Speel een spel</h1>
        <br>
        <form action="./uitkomst.php" method="POST">
            <input class="button" name="player_choice" id="player_choice" type="submit" value="steen">
            <input class="button" name="player_choice" id="player_choice" type="submit" value="papier">
            <input class="button" name="player_choice" id="player_choice" type="submit" value="schaar">
        </form>
    </main>

    <footer>
        <button>regels</button>
    </footer>
</body>
</html>