// console.log("Het globale javascript bestand is gekoppeld");
document.addEventListener("DOMContentLoaded", () => {
    const showBtn = document.getElementById("show_rules_btn");
    const rulesWindow = document.querySelector(".rules_window");
    const closeBtn = rulesWindow.querySelector("button");

    // Openen
    showBtn.addEventListener("click", (e) => {
        e.stopPropagation(); // voorkomt dat body click meteen sluit
        rulesWindow.classList.add("active");
    });

    // Sluiten met ✕ knop
    closeBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        rulesWindow.classList.remove("active");
    });

    // Sluiten als je buiten de rules_window klikt
    document.body.addEventListener("click", (e) => {
        if (rulesWindow.classList.contains("active") && !rulesWindow.contains(e.target)) {
            rulesWindow.classList.remove("active");
        }
    });

    // Zorg dat klikken in rules_window niet bubbelt naar body
    rulesWindow.addEventListener("click", (e) => {
        e.stopPropagation();
    });
});
