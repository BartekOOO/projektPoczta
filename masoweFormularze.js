var wiadomosci = document.querySelectorAll(".wiadomosc");
function masowoUsunWiadomosci() {
    var formularz = document.createElement("form");
    formularz.method = "POST";
    formularz.action = "Scripts/masowe/masoweUsuwanie.php";

    var pole = document.createElement("input");
    pole.type = "hidden";
    pole.name = "dane";

    var wiadomosciZaznaczone = [];

    wiadomosci.forEach(function (wiad) {
        var checkbox = wiad.querySelector(".kwadracik.zaznaczanie");
        var idW = wiad.querySelector(".idW").value;

        if (checkbox.checked) {
            wiadomosciZaznaczone.push(idW);
        }
    });

    pole.value = wiadomosciZaznaczone.join(";");

    formularz.appendChild(pole);

    document.body.appendChild(formularz);
    formularz.submit();
}



function masowoOznaczJakoSpam() {
    var formularz = document.createElement("form");
    formularz.method = "POST";
    formularz.action = "Scripts/masowe/masowePrzenoszenieDoSpamu.php";

    var pole = document.createElement("input");
    pole.type = "hidden";
    pole.name = "dane";

    var wiadomosciZaznaczone = [];

    wiadomosci.forEach(function (wiad) {
        var checkbox = wiad.querySelector(".kwadracik.zaznaczanie");
        var idW = wiad.querySelector(".idW").value;

        if (checkbox.checked) {
            wiadomosciZaznaczone.push(idW);
        }
    });

    pole.value = wiadomosciZaznaczone.join(";");

    formularz.appendChild(pole);

    document.body.appendChild(formularz);

    formularz.submit();
}

function masowePrzenoszenieDoKosza() {
    var formularz = document.createElement("form");
    formularz.method = "POST";
    formularz.action = "Scripts/masowe/masowePrzenoszenieDoKosza.php";

    var pole = document.createElement("input");
    pole.type = "hidden";
    pole.name = "dane";

    var wiadomosciZaznaczone = [];

    wiadomosci.forEach(function (wiad) {
        var checkbox = wiad.querySelector(".kwadracik.zaznaczanie");
        var idW = wiad.querySelector(".idW").value;

        if (checkbox.checked) {
            wiadomosciZaznaczone.push(idW);
        }
    });

    pole.value = wiadomosciZaznaczone.join(";");

    formularz.appendChild(pole);

    document.body.appendChild(formularz);
    formularz.submit();
}

function masowoWyjmijZeSpamu() {
    var formularz = document.createElement("form");
    formularz.method = "POST";
    formularz.action = "Scripts/masowe/masoweWyjmowanieZeSpamu.php";

    var pole = document.createElement("input");
    pole.type = "hidden";
    pole.name = "dane";

    var wiadomosciZaznaczone = [];

    wiadomosci.forEach(function (wiad) {
        var checkbox = wiad.querySelector(".kwadracik.zaznaczanie");
        var idW = wiad.querySelector(".idW").value;

        if (checkbox.checked) {
            wiadomosciZaznaczone.push(idW);
        }
    });

    pole.value = wiadomosciZaznaczone.join(";");

    formularz.appendChild(pole);

    document.body.appendChild(formularz);
    formularz.submit();
}

function masowoWyjmijZKosza() {
    var formularz = document.createElement("form");
    formularz.method = "POST";
    formularz.action = "Scripts/masowe/masoweWyjmowanieZKosza.php";

    var pole = document.createElement("input");
    pole.type = "hidden";
    pole.name = "dane";

    var wiadomosciZaznaczone = [];

    wiadomosci.forEach(function (wiad) {
        var checkbox = wiad.querySelector(".kwadracik.zaznaczanie");
        var idW = wiad.querySelector(".idW").value;

        if (checkbox.checked) {
            wiadomosciZaznaczone.push(idW);
        }
    });

    pole.value = wiadomosciZaznaczone.join(";");

    formularz.appendChild(pole);

    document.body.appendChild(formularz);
    formularz.submit();
}
