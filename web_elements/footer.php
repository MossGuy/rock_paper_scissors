<footer>
    <?php if ($game && !$game_finished): ?>
    <form action="" method="post">
        <input class="button" type="submit" name="change" id="change" value="Verander spelmodus">
    </form>
    <button id="show_quit_btn">Stoppen</button>
    <button id="show_rules_btn">regels</button>
    <?php endif; ?>
</footer>