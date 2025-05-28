<footer>
    <?php if ($game && !$game_finished): ?>
    <form action="" method="post">
        <input class="button" type="submit" name="change" id="change" value="Verander spelmodus">
        <input class="button" type="submit" name="exit" id="exit" value="Stoppen">
    </form>
    <button>regels</button>

    <section>
        <!-- regels afbeelding dynamisch ophalen doormiddel van het pad atribuut van de class -->
         
    </section>
    <?php endif; ?>
</footer>