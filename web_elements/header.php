<?php
$title = 'Welkom'; // Default titel

$title = ((isset($player) && method_exists($game, 'getDisplayTitle')) ? $game->getDisplayTitle() : '');
$score = (isset($game) && method_exists($player, 'getScore')) ? $player->getScore($game->getTitle()) : '';
?>

<header>
    <section>
        <h2><?=$title?></h2>
    </section>

    <section class=" t_center <?= !$game_available ? 'unavailable' : '' ?>">
        <div class="score_window">
            <p><?=$player_name??''?></p>
            <p><?= isset($player) ? 'score' : '' ?></p>
            <p id="score"><?=$score?></p>
        </div>
    </section>

    <section class="<?= $game_available ? 'unavailable' : '' ?>">

    </section>
</header>
