<section class="popup_window" id="rules_window">
    <div class="flex_row j_content_between items_center">
        <h2>Regels</h2>
        <button class="close_btn">✕</button>
    </div>
    <img src="./images/svg_icons/<?=$game->getTitle()??'game_unavailable'?>/rules.svg" alt="">
</section>

<section class="popup_window" id="quit_window">
    <div class="flex_row j_content_between items_center">
        <h2>Weet je het zeker?</h2>
        <button class="close_btn">✕</button>
    </div>
    <form action="" method="post">
        <input class="button quit_button" type="submit" name="exit" id="exit" value="Stoppen">
    </form>
</section>