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
    <?php include "./web_elements/header.php"; ?>

    <main>
        <section class="game_window">
            <h1>Uitkomst:</h1>
            <p><?php print_r($_POST)?></p>
        </section>
    </main>

    <?php include "./web_elements/footer.php"; ?>
</body>
</html>