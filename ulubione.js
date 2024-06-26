$(document).ready(function() {
    $(".gwiazdkajs").on("click", function() {
        const akapit = $(this);
        const watekId = akapit.data("idwatku");

        $.post("Scripts/dodajDoUlubionych.php", { idWatku: watekId }, function(data) {
            akapit.toggleClass("pomalowane");
        });
    });
});