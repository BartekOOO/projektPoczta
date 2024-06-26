<?php
    $odbiorca = $_POST['odbiorca'];
    $wiadomosc = $_POST['wiadomosc'];
    $temat = $_POST['temat'];
    $dataWyslania = date('Y-m-d H:i:s');

    if(!empty($odbiorca)&&!empty($wiadomosc)&&!empty($temat)){
        $polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");

        session_start();
        $login = $_SESSION['login'];

        $zapytanie = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE login='$odbiorca';");
        while($wiersz=mysqli_fetch_array($zapytanie)){
            $idOdbiorcy = $wiersz['id'];
        }

        $zapytanie = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE login='$login';");
        while($wiersz=mysqli_fetch_array($zapytanie)){
            $idNadawcy = $wiersz['id'];
        }


        $zapytanie = "INSERT INTO Watki (tytul, wiadomosc, dataWyslania, idOdbiorcy, idNadawcy, nadawcaWidzi, odbiorcaWidzi, odczytanaPrzezNadawce,odczytanaPrzezOdbiorce) VALUES ('$temat', '$wiadomosc', '$dataWyslania', '$idOdbiorcy', '$idNadawcy', '1', '1','1','0');";
        if (mysqli_query($polaczenie, $zapytanie)) {
            $idWatku = mysqli_insert_id($polaczenie);
        }

        mysqli_query($polaczenie,"INSERT INTO Wiadomosci (idWatku,idOdbiorcy,idNadawcy,wiadomosc,dataWyslania,odbiorcaWidzi,nadawcaWidzi) VALUES ($idWatku,$idOdbiorcy,$idNadawcy,'$wiadomosc','$dataWyslania','1','1');");



        mysqli_close($polaczenie);

        header("Location: ../panel");
        exit();
    }else{
        echo "<script type='text/javascript'>
        alert('Błąd: Niewypełniono pól');
        window.location.href = '../panel';
      </script>";
        exit();
    }
?>