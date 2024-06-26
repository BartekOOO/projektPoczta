<?php
    $idOdbiorcy = $_POST['idOdbiorcy'];
    $idNadawcy = $_POST['idNadawcy'];
    $wiadomosc = $_POST['wiadomosc'];
    $idWatku = $_POST['idWatku'];
    $dataWyslania = date('Y-m-d H:i:s');
    

    $polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");

    $login = $_SESSION['login'];
    $zapytanie = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE login='$login';");
    while($wiersz=mysqli_fetch_array($zapytanie)){
        $idZalogowanego = $wiersz['id'];
    }

    mysqli_query($polaczenie,"INSERT INTO Wiadomosci (idWatku,idOdbiorcy,idNadawcy,wiadomosc,dataWyslania,odbiorcaWidzi, 
    nadawcaWidzi) VALUES ($idWatku,$idOdbiorcy,$idNadawcy,'$wiadomosc','$dataWyslania','1','1');");

    if($idZalogowanego!=$idNadawcy){
        mysqli_query($polaczenie,"UPDATE Watki SET wiadomosc='$wiadomosc', dataWyslania='$dataWyslania', odczytanaPrzezOdbiorce='0', nadawcaWidzi='1', odbiorcaWidzi='1' WHERE id=$idWatku;");
    }

    mysqli_query($polaczenie,"UPDATE Watki SET wiadomosc='$wiadomosc', dataWyslania='$dataWyslania', odczytanaPrzezNadawce='0', nadawcaWidzi='1', odbiorcaWidzi='1' WHERE id=$idWatku;");
    

    mysqli_query($polaczenie,"UPDATE Watki SET wiadomosc='$wiadomosc', dataWyslania='$dataWyslania', odczytanaPrzezNadawce='1', odczytanaPrzezOdbiorce='1', nadawcaWidzi='1', odbiorcaWidzi='1' WHERE id=$idWatku AND idNadawcy=idOdbiorcy;");
    

    mysqli_close($polaczenie);

    header("Location: ../panel?tryb=8&wiad=$idWatku");
    exit();

?>