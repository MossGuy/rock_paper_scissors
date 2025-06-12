// console.log("Het globale javascript bestand is gekoppeld");
document.addEventListener("DOMContentLoaded", () => {
    const popups = document.querySelectorAll(".popup_window");
    const showBtn = document.getElementById("show_rules_btn");
    const quitBtn = document.getElementById("show_quit_btn");

    // Functie om een popup te openen en de rest te sluiten
    function openPopup(targetPopup) {
        popups.forEach(popup => {
            if (popup === targetPopup) {
                popup.classList.add("active");
            } else {
                popup.classList.remove("active");
            }
        });
    }

    // Sluit alle popups
    function closeAllPopups() {
        popups.forEach(popup => popup.classList.remove("active"));
    }

    // Eventlistener voor sluitenknoppen binnen elke popup
    popups.forEach(popup => {
        const closeBtns = popup.querySelectorAll(".close_btn");
        closeBtns.forEach(btn => {
            btn.addEventListener("click", (e) => {
                e.stopPropagation();
                popup.classList.remove("active");
            });
        });

        // Voorkom sluiten als er binnen de popup wordt geklikt
        popup.addEventListener("click", e => e.stopPropagation());
    });

    // Open knoppen
    showBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        openPopup(document.getElementById("rules_window"));
    });

    quitBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        openPopup(document.getElementById("quit_window"));
    });

    // Sluit popup als je buiten klikt
    document.body.addEventListener("click", () => {
        closeAllPopups();
    });
});
