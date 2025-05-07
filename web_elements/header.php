<header>
    <section class="<?= !$game_available ? 'unavailable' : '' ?>">
        <!-- TODO: fout afhandeling wanneer de variabel niet gelezen kan worden -->
        <h2><?=$game->getTitle()??'Game'?></h2>
    </section>

    <section class="score_window <?= !$game_available ? 'unavailable' : '' ?>">
        <p>score</p>
        <!-- score ophalen -->
        <p id="score"><?=''?></p>
    </section>

    <section class="<?= $game_available ? 'unavailable' : '' ?>">

    </section>
</header>