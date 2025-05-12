<?php
$title = (isset($game) && method_exists($game, 'getDisplayTitle')) ? $game->getDisplayTitle() : 'Game niet gevonden :(';
$score = (isset($game) && method_exists($player, 'getScore')) ? $player->getScore($game->getTitle()) : '0';
?>
<header>
    <section>
        <h2><?=$title?></h2>
    </section>

    <section class=" t_center <?= !$game_available ? 'unavailable' : '' ?>">
        <div class="score_window">
            <p><?=$player->getName()?></p>
            <p>score</p>
            <p id="score"><?=$score?></p>
        </div>
    </section>

    <section class="<?= $game_available ? 'unavailable' : '' ?>">

    </section>
</header>