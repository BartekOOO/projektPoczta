<?php
session_start();
if (!isset($_SESSION['login']) || !isset($_SESSION['haslo'])||!isset($_SESSION['admin'])||!isset($_SESSION['bog'])||!isset($_SESSION['id'])||!isset($_SESSION['zablokowany'])) {
    session_destroy();
    header("Location: logowanie");
    exit();
}

$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");
$id = $_SESSION['id'];
$zapytanie=mysqli_query($polaczenie,"SELECT zablokowany FROM Uzytkownicy WHERE id=$id;");
while($wiersz=mysqli_fetch_array($zapytanie)){
    if($wiersz[0]==1){
        session_destroy();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Styles/fonty.css" rel="stylesheet">
    <link href="Styles/wiadomosci.css" rel="stylesheet">
    <link href="Styles/wiadomoscijs.css" rel="stylesheet">
    <link href="Styles/okienkoDialogowe.css" rel="stylesheet">
    <link href="Styles/odpisywanie.css" rel="stylesheet">
    <link href="Styles/znajomi.css" rel="stylesheet">
    <link href="Styles/dialog.css" rel="stylesheet">
    <link href="Styles/style.css" rel="stylesheet">
    <link rel="icon" href="Images/p.png" type="image/png">
    <title><?php echo $_SESSION['login']; ?></title>
</head>
<body>
    <div id="container">
        <div id="top">
            <div class="kafelek alignLeft">
                <span class="napis szary gruby">UPH Projekt Poczta</span>
            </div>
            <div class="kafelek alignCenter">
                <form method="GET" action="panel">
                    <input class="searchbar szary" value='<?php if(!empty($_GET['fraza'])){ echo $_GET['fraza'];} ?>'
                    placeholder="Szukaj wiadomości" type="text" name="fraza"/><input type='hidden' name='tryb' value="11">
                </form>
            </div>
            <div class="kafelek alignRight">
                <a style="text-decoration:none; float:right;" href="Scripts/wyloguj.php"><Button
                        class="przycisk1 cszary gruby" type="submit">Wyloguj</Button></a>
                <a style="text-decoration:none; float:right; margin-right:10px;"><Button class="przycisk1 cszary gruby"
                        type="submit" onClick='konto()'>Konto</Button></a>
            </div>
        </div>
        <div style="display: flex; height: 100%;">
            <div id="leftPanel">
                <div class="optionD napis1 cczarny" onClick='okienkoWysylaniaWlacz()' id="createButton">Utwórz</div>
                <div class="option <?php if(empty($_GET['tryb'])||$_GET['tryb']=='1'){ echo 'gruby';} ?>"><a class="napis2 szary" style="text-decoration:none;" href="panel?tryb=1">
                        <div>Odebrane</div>
                    </a></div>
                <div class="option <?php if($_GET['tryb']=='2'){ echo 'gruby';} ?>"><a class="napis2 szary" style="text-decoration:none;" href="panel?tryb=2">
                        <div>Wysłane</div>
                    </a></div>
                <div class="option <?php if($_GET['tryb']=='3'){ echo 'gruby';} ?>"><a class="napis2 szary" style="text-decoration:none;" href="panel?tryb=3">
                        <div>Spam</div>
                    </a></div>
                <div class="option <?php if($_GET['tryb']=='4'){ echo 'gruby';} ?>"><a class="napis2 szary" style="text-decoration:none;" href="panel?tryb=4">
                        <div>Kosz</div>
                    </a></div>
                <div class="option <?php if($_GET['tryb']=='6'){ echo 'gruby';} ?>"><a class="napis2 szary" style="text-decoration:none;" href="panel?tryb=6">
                        <div>Znajomi</div>
                    </a></div>
                <div class="option <?php if($_GET['tryb']=='10'){ echo 'gruby';} ?>"><a class="napis2 szary" style="text-decoration:none;" href="panel?tryb=10">
                    <div>Szukaj znajomych</div>
                </a></div>
                <?php
                    if($_SESSION['admin']){
                        $kolor='';
                        
                        if(isset($_GET['tryb'])){
                        if($_GET['tryb']=='12'){ $kolor='gruby';}}

                        echo "<div class='option $kolor'><a 
                        class='napis2 czerwony' style='text-decoration:none;'
                         href='panel?tryb=12'><div>Zgłoszenia</div></a></div>";
                    }
                ?>

                <?php
                    if($_SESSION['admin']){
                        $kolor='';
                        
                        if(isset($_GET['tryb'])){
                        if($_GET['tryb']=='14'){ $kolor='gruby';}}

                        echo "<div class='option $kolor'><a 
                        class='napis2 czerwony' style='text-decoration:none;'
                         href='panel?tryb=14'><div>Zbanowani</div></a></div>";
                    }
                ?>

                <?php
                    if($_SESSION['bog']){
                        $kolor='';
                        
                        if(isset($_GET['tryb'])){
                        if($_GET['tryb']=='15'){ $kolor='gruby';}}

                        echo "<div class='option $kolor'><a 
                        class='napis2 niebieski' style='text-decoration:none;'
                         href='panel?tryb=15'><div>Admini</div></a></div>";
                    }
                ?>
            </div>
            <div id="main">
                <div id="opcje" class="opcje">
                    <?php 
                    if(isset($_GET['tryb'])){
                        $tryb=$_GET['tryb'];
                    }else{
                        $tryb=1;
                    }
                        if($tryb==1){
                            echo "<span class='cszary napis3'><button onClick='masowoUsunWiadomosci()' class='dialog-przycisk cszary gruby'>Usuwanie</button>
                            <button onClick='masowoOznaczJakoSpam()' class='dialog-przycisk cszary gruby'>Oznacz jako spam</button>
                            <button onClick='masowePrzenoszenieDoKosza()' class='dialog-przycisk cszary gruby'>Przenieś do kosza</button></span>";
                        }else if($tryb==2){
                            echo "<span class='cszary napis3'><button onClick='masowoUsunWiadomosci()' class='dialog-przycisk cszary gruby'>Usuwanie</button> 
                            <button onClick='masowePrzenoszenieDoKosza()' class='dialog-przycisk cszary gruby'>Przenieś do kosza</button>";
                        }
                        else if($tryb==3){
                            echo "<span class='cszary napis3'><button onClick='masowoUsunWiadomosci()' class='dialog-przycisk cszary gruby'>Usuwanie</button>
                            <button onClick='masowePrzenoszenieDoKosza()' class='dialog-przycisk cszary gruby'>Przenieś do kosza</button>
                            <button onClick='masowoWyjmijZeSpamu()' class='dialog-przycisk cszary gruby'>Wyjmij ze spamu</button></span>";
                        }else if($tryb==4){
                            echo "<span class='cszary napis3'><button onClick='masowoUsunWiadomosci()' class='dialog-przycisk cszary gruby'>Usuwanie</button>
                            <button onClick='masowoWyjmijZKosza()' class='dialog-przycisk cszary gruby'>Wyjmij z kosza</button></span>";
                        }else if($tryb==6||$tryb==8||$tryb==10||$tryb==11||$tryb==12||$tryb==13||$tryb==9||$tryb==14||$tryb==15){
                            
                        }else{
                            header("Location: panel?tryb=1");
                            exit();
                        }
                    ?>
                </div>
                <?php

                
                setlocale(LC_TIME, 'pl_PL.UTF-8');
                function skrocTekst($tekst, $dlugosc = 70) {
                    if (strlen($tekst) > $dlugosc) {
                        return substr($tekst, 0, $dlugosc) . '...';
                    } else {
                        return $tekst;
                    }
                }

                $login = $_SESSION['login'];
                $polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");
        
                $zapytanie = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE login='$login';");
                while($wiersz=mysqli_fetch_array($zapytanie)){
                    $idZalogowanego = $wiersz['id'];
                }

                if(empty($_GET['tryb'])||$_GET['tryb']=='1'){

                    #na początek wypisywanie wiadomości wysłanych przez nadawcę ale jednocześnie na które odpisał odbiorca
                    $zapytanie = mysqli_query($polaczenie,"SELECT Watki.id AS watkiId, tytul, wiadomosc, dataWyslania, idOdbiorcy, idNadawcy, nadawcaWidzi, odbiorcaWidzi, odczytanaPrzezNadawce FROM Watki INNER JOIN Uzytkownicy ON Watki.idNadawcy = Uzytkownicy.id WHERE Uzytkownicy.login = '$login' AND Watki.nadawcaWidzi = '1' AND Watki.odczytanaPrzezNadawce='0' AND Watki.nadawcaSpam='0' AND Watki.nadawcaKosz='0' ORDER BY Watki.dataWyslania DESC;");
            
                    while($wiersz=mysqli_fetch_array($zapytanie)){
                        $odbiorca = $wiersz['idOdbiorcy'];
                        $id = $wiersz['watkiId'];
                        if($wiersz['odczytanaPrzezNadawce']){
                            $klasa = '';
                        }
                        else{
                            $klasa = 'gruby';
                        }
                        $zapytanie2 = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE id='$odbiorca';");
                        echo "<div class='wiadomosc $klasa napis3 cszary'>";
                        echo "<input type='checkbox' class='kwadracik zaznaczanie'>";
                        echo "<div class='tytul'>{$wiersz['tytul']}</div>";
                        echo "<input type='hidden' class='idW' value='$id'>";
                        while($wiersz2=mysqli_fetch_array($zapytanie2)){
                            echo "<div class='nadawca'>{$wiersz2['login']}</div>";
                        }
                        echo "<div class='kawalek'>" . skrocTekst($wiersz['wiadomosc']) . "</div>";
                        $dataWyslania = $wiersz['dataWyslania'];
                        $dataWyslania = strtotime($dataWyslania);
                        $dataWyslania = strftime('%Y-%m-%d',$dataWyslania);
                        echo "<div class='data'>$dataWyslania</div>";
                        echo "</div>";
                    }

                    #pozostałe
                    $zapytanie = mysqli_query($polaczenie,"SELECT Watki.id AS watkiId, tytul, wiadomosc, dataWyslania, idOdbiorcy, idNadawcy, nadawcaWidzi, odbiorcaWidzi, odczytanaPrzezOdbiorce FROM Watki INNER JOIN Uzytkownicy ON Watki.idOdbiorcy = Uzytkownicy.id WHERE Uzytkownicy.login = '$login' AND Watki.odbiorcaWidzi = '1' AND Watki.odbiorcaSpam='0' AND Watki.odbiorcaKosz='0' ORDER BY Watki.dataWyslania DESC;");
            
                    while($wiersz=mysqli_fetch_array($zapytanie)){
                        $nadawca = $wiersz['idNadawcy'];
                        $id = $wiersz['watkiId'];
                        $zapytanie2 = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE id='$nadawca';");
                        if($wiersz['odczytanaPrzezOdbiorce']){
                            $klasa = '';
                        }
                        else{
                            $klasa = 'gruby';
                        }
                        echo "<div class='wiadomosc wiadomoscjs $klasa napis3 cszary'>";
                        echo "<input type='checkbox' class='kwadracik zaznaczanie'>";

                        $zapytanieOUlubione = mysqli_query($polaczenie,"SELECT * FROM ulubione WHERE idWatku=$id AND idUzytkownika=$idZalogowanego;");
                        $ulub="";
                        while($wierszUlubione=mysqli_fetch_array($zapytanieOUlubione)){
                            $ulub="pomalowane";
                        }

                        echo "<span data-idWatku='$id' class='gwiazdkajs zaznaczanie $ulub'>&#9733;</span>";
                        echo "<div class='tytuljs'>{$wiersz['tytul']}</div>";
                        echo "<input type='hidden' class='idW' value='$id'>";
                        while($wiersz2=mysqli_fetch_array($zapytanie2)){
                            echo "<div class='nadawcajs'>{$wiersz2['login']}</div>";
                        }
                        echo "<div class='kawalekjs'>" . skrocTekst($wiersz['wiadomosc']) . "</div>";
                        $dataWyslania = $wiersz['dataWyslania'];
                        $dataWyslania = strtotime($dataWyslania);
                        $dataWyslania = strftime('%Y-%m-%d',$dataWyslania);
                        echo "<div class='datajs'>$dataWyslania</div>";
                        echo "</div>";
                    }
                }else if($_GET['tryb']=='2'){
                    $zapytanie = mysqli_query($polaczenie,"SELECT Watki.id AS watkiId, tytul, wiadomosc, dataWyslania, idOdbiorcy, idNadawcy, nadawcaWidzi, odbiorcaWidzi, odczytanaPrzezNadawce FROM Watki INNER JOIN Uzytkownicy ON Watki.idNadawcy = Uzytkownicy.id WHERE Uzytkownicy.login = '$login' AND Watki.nadawcaWidzi = '1' AND Watki.nadawcaSpam='0' AND Watki.nadawcaKosz='0' ORDER BY Watki.dataWyslania DESC;");
            
                    while($wiersz=mysqli_fetch_array($zapytanie)){
                        $odbiorca = $wiersz['idOdbiorcy'];
                        $id = $wiersz['watkiId'];
                        if($wiersz['odczytanaPrzezNadawce']){
                            $klasa = '';
                        }
                        else{
                            $klasa = 'gruby';
                        }
                        $zapytanie2 = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE id='$odbiorca';");
                        echo "<div class='wiadomosc $klasa napis3 cszary'>";
                        echo "<input type='checkbox' class='kwadracik zaznaczanie'>";
                        echo "<div class='tytul'>{$wiersz['tytul']}</div>";
                        echo "<input type='hidden' class='idW' value='$id'>";
                        while($wiersz2=mysqli_fetch_array($zapytanie2)){
                            echo "<div class='nadawca'>{$wiersz2['login']}</div>";
                        }
                        echo "<div class='kawalek'>" . skrocTekst($wiersz['wiadomosc']) . "</div>";
                        $dataWyslania = $wiersz['dataWyslania'];
                        $dataWyslania = strtotime($dataWyslania);
                        $dataWyslania = strftime('%Y-%m-%d',$dataWyslania);
                        echo "<div class='data'>$dataWyslania</div>";
                        echo "</div>";
                    }
                }else if($_GET['tryb']=='8'){
                    $wiad = $_GET['wiad'];
                    $zapytanie = mysqli_query($polaczenie,"SELECT * FROM Wiadomosci WHERE idWatku=$wiad;");

                    while($wiersz=mysqli_fetch_array($zapytanie)){
                        if($idZalogowanego!=$wiersz['idOdbiorcy']&&$idZalogowanego!=$wiersz['idNadawcy']){
                            header("Location: panel?tryb=9");
                            exit();
                        }
                        $zm = $wiersz['idNadawcy'];
                        $dataWyslania = $wiersz['dataWyslania'];
                        $dataWyslania = strtotime($dataWyslania);
                        $dataWyslania = strftime('%d %B %Y, %H:%M',$dataWyslania);
                        $wiadomosc = $wiersz['wiadomosc'];
                        $zapytanie2 = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE id=$zm;");
                        while($wiersz2=mysqli_fetch_array($zapytanie2)){
                            $imieNadawcy = $wiersz2['imie'];
                            $nazwiskoNadawcy = $wiersz2['nazwisko'];
                        }  

                        $zapytanieDodatkowe = mysqli_query($polaczenie,"SELECT idOdbiorcy, idNadawcy FROM Watki WHERE id=$wiad;");
                        while($wierszDod=mysqli_fetch_array($zapytanieDodatkowe)){
                            $idOdbiorcy=$wierszDod[0];
                            if($idZalogowanego==$idOdbiorcy){
                                $idOdbiorcy=$wierszDod[1];
                                mysqli_query($polaczenie,"UPDATE Watki SET odczytanaPrzezOdbiorce='1' WHERE id='$wiad'");
                            }else{
                                mysqli_query($polaczenie,"UPDATE Watki SET odczytanaPrzezNadawce='1' WHERE id='$wiad'");
                            }
                        }

                        

                        echo "<div class='dialog'>";
                        echo "<div class='dialog-header'>";
                        echo "<div class='dialog-nadawca cszary gruby napis3'>$imieNadawcy $nazwiskoNadawcy</div>";
                        echo "<div class='dialog-data szary napis3'>$dataWyslania</div>";
                        echo "</div>";
                        echo "<div class='dialog-wiadomosc cszary napis4'>$wiadomosc</div>";
                        echo "</div>";  
                    }
                    echo "<br>";
                    echo "<button id='odpisywanie-przycisk' onClick='wysylanieWiadomosci()' class='dialog-przycisk cszary gruby'>Wyślij wiadomość</button>";
                    echo "<button onClick='usunWiadomosc(\"$wiad\",\"$idOdbiorcy\")' id='odpisywanie-przycisk-anuluj' class='dialog-przycisk cszary gruby'>Usuń</button>";
                    echo "<button onClick='zglosUzytkownika(\"$wiad\")' id='odpisywanie-przycisk-zglos' 
                    class='dialog-przycisk cszary gruby'>Zgłoś wiadomość</button>";


                    
                    echo "<form method='POST' action='Scripts/wyslijWiadomoscWatku.php' id='odpisywanie-form' style='display: none;'>";
                    echo "<textarea id='nowa-wiadomosc' class='tekstarela2 napis3 cszary odpisywanie' style='width:95%;' placeholder='Tutaj wpisz swoją wiadomość'
                             id='message1' name='wiadomosc' rows='10'
                            cols='100'></textarea>
                            <input type='hidden' value='$wiad' name='idWatku'>
                            <input type='hidden' value='$idOdbiorcy' name='idOdbiorcy'>
                            <input type='hidden' value='$idZalogowanego' name='idNadawcy'>
                            <br>";
                    echo "<input class='dialog-przycisk cszary gruby' type='submit' value='Wyślij wiadomość'>";
                    echo "</form>";

                    
                }else if($_GET['tryb']==9){
                    echo "<span class='napis gruby czerwony'>No wiesz co? Tego się po tobie nie spodziewałem... Tak brzydko oszukiwać?</span>";
                }else if($_GET['tryb']==6){
                    $zapytanie = mysqli_query($polaczenie,"SELECT Uzytkownicy.login, Uzytkownicy.imie,
                     Uzytkownicy.nazwisko, Uzytkownicy.id, Uzytkownicy.admin, Uzytkownicy.bog, Uzytkownicy.zablokowany FROM Uzytkownicy INNER JOIN Znajomi ON
                    Znajomi.idZnajomego = Uzytkownicy.id WHERE Znajomi.idUzytkownika = $idZalogowanego;");
                    echo "<span class='napis1 gruby cszary'>Lista znajomych</span>";  
                    while($wiersz=mysqli_fetch_array($zapytanie)){
                        $login = $wiersz[0];
                        $imie = $wiersz[1];
                        $nazwisko = $wiersz[2];
                        $idZnajomego = $wiersz[3];
                        $admin = $wiersz[4];
                        $bog = $wiersz[5];
                        $zablokowany = $wiersz[6];

                        $typUzytkownika="<span class='zielony'>Uzytkownik poczty</span>";
                        if($admin){
                            $typUzytkownika="<span class='czerwony'>Administrator</span>";
                        }
                        if($bog){
                            $typUzytkownika="<span class='niebieski'>Bóg</span>";
                        }
                        if($zablokowany){
                            $typUzytkownika="<span class='czerwony gruby'>Użytkownik zablokowany</span>";
                        }

                        echo "<div class='dialog-znajomy'>";
                        echo "<div class='dialog-znajomy-header'>";
                        echo "<div class='dialog-znajomy-nadawca cszary gruby napis3'>$login</div>";
                        echo "</div>";
                        echo "<div class='dialog-znajomy-wiadomosc cszary napis3'>$imie $nazwisko</div>";
                        echo "<div class='dialog-znajomy-wiadomosc cszary napis4'>$typUzytkownika</div>";
                        echo "<input type='hidden' name='idZnajomego' value='$idZnajomego'>";
                        echo "<div class='dialog-znajomy-buttons'>";
                        echo "<form method='POST' action='Scripts/usunZnajomego.php'><input type='hidden' name='id' value='$idZalogowanego'>
                        <input type='hidden' name='idZnajomego' value='$idZnajomego'>
                        <input class='dialog-znajomy-przycisk cszary gruby' type='submit' value='Usuń znajomego'></form>";
                        echo "<input class='dialog-znajomy-przycisk cszary gruby' type='button' value='Wyślij wiadomość' onclick='wyslijWiadomosc(\"$login\")'>";
                        echo "</div></div>";                        
                    }
                }else if($_GET['tryb']==10){
                    $zapytanie = mysqli_query($polaczenie,"SELECT login, id FROM Uzytkownicy WHERE ukryteKonto = '0';");
                    echo "<span class='napis1 gruby cszary'>Potencjalni znajomi:</span>";  
                    while($wiersz=mysqli_fetch_array($zapytanie)){
                        $login = $wiersz[0];
                        $id = $wiersz[1];

                        $napisPrzycisku = "Wyślij zaproszenie";
                        $moznaWyswietlic = '1';
                        $trybZapraszania = '1';
                        $kolorek = "cszary";
                        $zapytanie2 = mysqli_query($polaczenie,"SELECT * FROM Znajomi WHERE idZnajomego=$id AND idUzytkownika=$idZalogowanego;");
                        while($wiersz2 = mysqli_fetch_array($zapytanie2)){
                            $moznaWyswietlic='0';
                        }

                        $zapytanie3 = mysqli_query($polaczenie,"SELECT * FROM Zaproszenia WHERE idZaproszonego=$idZalogowanego AND idZapraszajacego=$id;");
                        while($wiersz3 = mysqli_fetch_array($zapytanie3)){
                            $napisPrzycisku = "Przyjmij zaproszenie";
                            $trybZapraszania = '2';
                            $kolorek="zielony";
                        }

                        
                        $zapytanie4 = mysqli_query($polaczenie,"SELECT * FROM Zaproszenia WHERE idZaproszonego=$id AND idZapraszajacego=$idZalogowanego;");
                        while($wiersz4 = mysqli_fetch_array($zapytanie4)){
                            $moznaWyswietlic='0';
                        }

                        if($moznaWyswietlic&&$idZalogowanego!=$id){
                            echo "<div class='dialog-znajomy'>";
                            echo "<div class='dialog-znajomy-header'>";
                            echo "<div class='dialog-znajomy-buttons'>";
                            echo "<form method='POST' action='Scripts/wyslijZaproszenieDoZnajomych.php'>
                            <input type='hidden' name='trybZapraszania' value='$trybZapraszania'>
                            <input type='hidden' name='idZapraszajacego' value='$idZalogowanego'>
                            <input type='hidden' name='idZapraszanego' value='$id'>
                            <input style='width:160px;' class='dialog-znajomy-przycisk $kolorek gruby' type='submit' value='$napisPrzycisku'>
                            <span class='gruby cszary napis2'>$login</span></form>";
                            echo "</div></div></div>";            
                        }            
                    }
                }else if($_GET['tryb']==3){
                    #na początek wypisywanie wiadomości wysłanych przez nadawcę ale jednocześnie na które odpisał odbiorca
                    $zapytanie = mysqli_query($polaczenie,"SELECT Watki.id AS watkiId, tytul, wiadomosc, dataWyslania, idOdbiorcy, idNadawcy, nadawcaWidzi, odbiorcaWidzi, odczytanaPrzezNadawce FROM Watki INNER JOIN Uzytkownicy ON Watki.idNadawcy = Uzytkownicy.id WHERE Uzytkownicy.login = '$login' AND Watki.nadawcaWidzi = '1' AND Watki.odczytanaPrzezNadawce='0' AND Watki.nadawcaSpam='1' AND Watki.nadawcaKosz='0' ORDER BY Watki.dataWyslania DESC;");
            
                    while($wiersz=mysqli_fetch_array($zapytanie)){
                        $odbiorca = $wiersz['idOdbiorcy'];
                        $id = $wiersz['watkiId'];
                        if($wiersz['odczytanaPrzezNadawce']){
                            $klasa = '';
                        }
                        else{
                            $klasa = 'gruby';
                        }
                        $zapytanie2 = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE id='$odbiorca';");
                        echo "<div class='wiadomosc $klasa napis3 cszary'>";
                        echo "<input type='checkbox' class='kwadracik zaznaczanie'>";
                        echo "<div class='tytul'>{$wiersz['tytul']}</div>";
                        echo "<input type='hidden' class='idW' value='$id'>";
                        while($wiersz2=mysqli_fetch_array($zapytanie2)){
                            echo "<div class='nadawca'>{$wiersz2['login']}</div>";
                        }
                        echo "<div class='kawalek'>" . skrocTekst($wiersz['wiadomosc']) . "</div>";
                        $dataWyslania = $wiersz['dataWyslania'];
                        $dataWyslania = strtotime($dataWyslania);
                        $dataWyslania = strftime('%Y-%m-%d',$dataWyslania);
                        echo "<div class='data'>$dataWyslania</div>";
                        echo "</div>";
                    }

                    #pozostałe
                    $zapytanie = mysqli_query($polaczenie,"SELECT Watki.id AS watkiId, tytul, wiadomosc, dataWyslania, idOdbiorcy, idNadawcy, nadawcaWidzi, odbiorcaWidzi, odczytanaPrzezOdbiorce FROM Watki INNER JOIN Uzytkownicy ON Watki.idOdbiorcy = Uzytkownicy.id WHERE Uzytkownicy.login = '$login' AND Watki.odbiorcaWidzi = '1' AND Watki.odbiorcaSpam='1' AND Watki.odbiorcaKosz='0' ORDER BY Watki.dataWyslania DESC;");
            
                    while($wiersz=mysqli_fetch_array($zapytanie)){
                        $nadawca = $wiersz['idNadawcy'];
                        $id = $wiersz['watkiId'];
                        $zapytanie2 = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE id='$nadawca';");
                        if($wiersz['odczytanaPrzezOdbiorce']){
                            $klasa = '';
                        }
                        else{
                            $klasa = 'gruby';
                        }
                        echo "<div class='wiadomosc $klasa napis3 cszary'>";
                        echo "<input type='checkbox' class='kwadracik zaznaczanie'>";
                        echo "<div class='tytul'>{$wiersz['tytul']}</div>";
                        echo "<input type='hidden' class='idW' value='$id'>";
                        while($wiersz2=mysqli_fetch_array($zapytanie2)){
                            echo "<div class='nadawca'>{$wiersz2['login']}</div>";
                        }
                        echo "<div class='kawalek'>" . skrocTekst($wiersz['wiadomosc']) . "</div>";
                        $dataWyslania = $wiersz['dataWyslania'];
                        $dataWyslania = strtotime($dataWyslania);
                        $dataWyslania = strftime('%Y-%m-%d',$dataWyslania);
                        echo "<div class='data'>$dataWyslania</div>";
                        echo "</div>";
                    }
                }else if($_GET['tryb']==4){
                
                    $zapytanie = mysqli_query($polaczenie, "
                    SELECT DISTINCT Watki.id AS watkiId, tytul, wiadomosc, dataWyslania, idOdbiorcy, idNadawcy, nadawcaWidzi, odbiorcaWidzi, odczytanaPrzezOdbiorce 
                     FROM Watki 
                    INNER JOIN Uzytkownicy ON (Watki.idOdbiorcy = Uzytkownicy.id OR Watki.idNadawcy = Uzytkownicy.id) 
                    WHERE Uzytkownicy.login = '$login' 
                    AND Watki.odbiorcaWidzi = '1' 
                    AND Watki.odbiorcaSpam = '0' 
                    AND (Watki.odbiorcaKosz = '1' OR Watki.nadawcaKosz = '1') 
                    ORDER BY Watki.dataWyslania DESC
                    ");

            
                    while($wiersz=mysqli_fetch_array($zapytanie)){
                        $nadawca = $wiersz['idNadawcy'];
                        $id = $wiersz['watkiId'];
                        $zapytanie2 = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE id='$nadawca';");
                        echo "<div class='wiadomosc napis3 cszary'>";
                        echo "<input type='checkbox' class='kwadracik zaznaczanie'>";
                        echo "<div class='tytul'>{$wiersz['tytul']}</div>";
                        echo "<input type='hidden' class='idW' value='$id'>";
                        while($wiersz2=mysqli_fetch_array($zapytanie2)){
                            echo "<div class='nadawca'>{$wiersz2['login']}</div>";
                        }
                        echo "<div class='kawalek'>" . skrocTekst($wiersz['wiadomosc']) . "</div>";
                        $dataWyslania = $wiersz['dataWyslania'];
                        $dataWyslania = strtotime($dataWyslania);
                        $dataWyslania = strftime('%Y-%m-%d',$dataWyslania);
                        echo "<div class='data'>$dataWyslania</div>";
                        echo "</div>";
                    }
                }else if($_GET['tryb']==11){
                    $fraza = $_GET['fraza'];
                    $zapytanie = mysqli_query($polaczenie, "
                    SELECT Watki.id AS watkiId, tytul, wiadomosc, dataWyslania, idOdbiorcy,
                           idNadawcy, nadawcaWidzi, odbiorcaWidzi
                    FROM Watki
                    INNER JOIN Uzytkownicy ON Watki.idOdbiorcy = Uzytkownicy.id OR Watki.idNadawcy = Uzytkownicy.id
                    WHERE Uzytkownicy.login = '$login' AND Watki.odbiorcaWidzi = '1' AND
                          (
                              wiadomosc LIKE '%$fraza%'
                              OR tytul LIKE '%$fraza%'
                          )
                    ORDER BY Watki.dataWyslania DESC;
                ");
                    
                    while($wiersz=mysqli_fetch_array($zapytanie)){
                        $nadawca = $wiersz['idNadawcy'];
                        $id = $wiersz['watkiId'];
                        $zapytanie2 = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE id='$nadawca';");

                        echo "<div class='wiadomosc napis3 cszary'>";
                        echo "<input type='checkbox' class='kwadracik zaznaczanie'>";
                        echo "<div class='tytul'>{$wiersz['tytul']}</div>";
                        echo "<input type='hidden' class='idW' value='$id'>";
                        while($wiersz2=mysqli_fetch_array($zapytanie2)){
                            echo "<div class='nadawca'>{$wiersz2['login']}</div>";
                        }
                        echo "<div class='kawalek'>" . skrocTekst($wiersz['wiadomosc']) . "</div>";
                        $dataWyslania = $wiersz['dataWyslania'];
                        $dataWyslania = strtotime($dataWyslania);
                        $dataWyslania = strftime('%Y-%m-%d',$dataWyslania);
                        echo "<div class='data'>$dataWyslania</div>";
                        echo "</div>";
                    }
                }else if($_GET['tryb']==12){
                    $zapytanie = mysqli_query($polaczenie,"SELECT Watki.id AS watkiId, tytul, wiadomosc, 
                    dataWyslania, idOdbiorcy, idNadawcy, rozpatrzono
                    FROM Watki INNER JOIN Zgloszenia ON Zgloszenia.idWatku = Watki.id WHERE rozpatrzono='0' ORDER BY Watki.dataWyslania DESC;");
            
                    while($wiersz=mysqli_fetch_array($zapytanie)){
                        $nadawca = $wiersz['idNadawcy'];
                        $id = $wiersz['watkiId'];
                        $zapytanie2 = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE id='$nadawca';");

                        echo "<div class='wiadomoscZgloszenia napis3 czerwony'>";
                        echo "<div class='tytul'>{$wiersz['tytul']}</div>";
                        echo "<input type='hidden' class='idW' value='$id'>";
                        while($wiersz2=mysqli_fetch_array($zapytanie2)){
                            echo "<div class='nadawca'>{$wiersz2['login']}</div>";
                        }
                        echo "<div class='kawalek'>" . skrocTekst($wiersz['wiadomosc']) . "</div>";
                        $dataWyslania = $wiersz['dataWyslania'];
                        $dataWyslania = strtotime($dataWyslania);
                        $dataWyslania = strftime('%Y-%m-%d',$dataWyslania);
                        echo "<div class='data'>$dataWyslania</div>";
                        echo "</div>";
                }
            }else if($_GET['tryb']==13){
                $wiad = $_GET['wiad'];
                $zapytanie = mysqli_query($polaczenie,"SELECT * FROM Wiadomosci WHERE idWatku=$wiad;");
                $zapytanie2 = mysqli_query($polaczenie,"SELECT * FROM Watki WHERE id=$wiad;");
                while($wiersz=mysqli_fetch_array($zapytanie2)){
                    $zmienna1 = $wiersz['idNadawcy'];
                    $zmienna2 = $wiersz['idOdbiorcy'];
                    $zapytanie4 = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE id='$zmienna1';");
                    while($wiersz3=mysqli_fetch_array($zapytanie4)){
                        $login1=$wiersz3["imie"]." ".$wiersz3['nazwisko'];
                    }

                    $zapytanie5 = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE id='$zmienna2';");
                    while($wiersz4=mysqli_fetch_array($zapytanie5)){
                        $login2=$wiersz4["imie"]." ".$wiersz4['nazwisko'];
                    }
                }

                while($wiersz=mysqli_fetch_array($zapytanie)){
                    if(!$_SESSION['admin']){
                        header("Location: panel?tryb=9");
                        exit();
                    }

                    $zm = $wiersz['idNadawcy'];
                    $dataWyslania = $wiersz['dataWyslania'];
                    $dataWyslania = strtotime($dataWyslania);
                    $dataWyslania = strftime('%d %B %Y, %H:%M',$dataWyslania);
                    $wiadomosc = $wiersz['wiadomosc'];
                    $zapytanie2 = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE id=$zm;");
                    while($wiersz2=mysqli_fetch_array($zapytanie2)){
                        $imieNadawcy = $wiersz2['imie'];
                        $nazwiskoNadawcy = $wiersz2['nazwisko'];
                    }  

                    $zapytanieDodatkowe = mysqli_query($polaczenie,"SELECT idOdbiorcy, idNadawcy FROM Watki WHERE id=$wiad;");
                    while($wierszDod=mysqli_fetch_array($zapytanieDodatkowe)){
                        $idOdbiorcy=$wierszDod[0];
                        if($idZalogowanego==$idOdbiorcy){
                            $idOdbiorcy=$wierszDod[1];
                            mysqli_query($polaczenie,"UPDATE Watki SET odczytanaPrzezOdbiorce='1' WHERE id='$wiad'");
                        }else{
                            mysqli_query($polaczenie,"UPDATE Watki SET odczytanaPrzezNadawce='1' WHERE id='$wiad'");
                        }
                    }

                    echo "<div class='dialog'>";
                    echo "<div class='dialog-header'>";
                    echo "<div class='dialog-nadawca cszary gruby napis3'>$imieNadawcy $nazwiskoNadawcy</div>";
                    echo "<div class='dialog-data szary napis3'>$dataWyslania</div>";
                    echo "</div>";
                    echo "<div class='dialog-wiadomosc cszary napis4'>$wiadomosc</div>";
                    echo "</div>";  
                }
                echo "<br>";
                echo "<button id='banuj-nadawce-przycisk' onClick='banujUzytkownika(\"$zmienna1\",\"$wiad\")' class='dialog-przycisk2 cszary gruby'>Banuj $login1</button>";
                echo "<button id='banuj-odbiorce-przycisk' onClick='banujUzytkownika(\"$zmienna2\",\"$wiad\")' class='dialog-przycisk2 cszary gruby'>Banuj $login2</button>";
                echo "<button onClick='odrzucZgloszenie(\"$wiad\")' id='przycisk-anuluj' class='dialog-przycisk cszary gruby'>Odrzuć</button>";
            }else if($_GET['tryb']==14){
                $zapytanie = mysqli_query($polaczenie,"SELECT login, id FROM Uzytkownicy WHERE zablokowany = '1';");
                echo "<span class='napis1 gruby czerwony'>Zbanowani użytkownicy:</span>";  
                while($wiersz=mysqli_fetch_array($zapytanie)){
                    $login = $wiersz[0];
                    $id = $wiersz[1];

                    echo "<div class='dialog-znajomy'>";
                    echo "<div class='dialog-znajomy-header'>";
                    echo "<div class='dialog-znajomy-buttons'>";
                    echo "<form method='POST' action='Scripts/odbanujUzytkownika.php'>
                        <input type='hidden' name='idZbanowanego' value='$id'>
                        <input style='width:160px;' class='dialog-znajomy-przycisk gruby' type='submit' value='Odbanuj'>
                        <span class='gruby cszary napis2'>$login</span></form>";
                    echo "</div></div></div>";                  
                }
            }else if($_GET['tryb']==15){

                echo "
            <form method='POST' action='Scripts/dodajAdmina.php'>
                <input style='width:40%; padding:4px; border:1px solid lightgray;' class='napis3 cszary' placeholder='Wpisz login osobie której chcesz dać admina' type='text'
                    id='subject' name='idAdmina'>
            </form><br>
                ";

                $zapytanie = mysqli_query($polaczenie,"SELECT login, id FROM Uzytkownicy WHERE admin = '1';");
                echo "<span class='napis1 gruby niebieski'>Admini:</span>";  
                while($wiersz=mysqli_fetch_array($zapytanie)){
                    $login = $wiersz[0];
                    $id = $wiersz[1];

                    echo "<div class='dialog-znajomy'>";
                    echo "<div class='dialog-znajomy-header'>";
                    echo "<div class='dialog-znajomy-buttons'>";
                    echo "<form method='POST' action='Scripts/usunAdmina.php'>
                        <input type='hidden' name='idAdmina' value='$id'>
                        <input style='width:160px;' class='dialog-znajomy-przycisk gruby' type='submit' value='Usuń admina'>
                        <span class='gruby cszary napis2'>$login</span></form>";
                    echo "</div></div></div>";                  
                }
            }
                mysqli_close($polaczenie);
            ?>
            </div>
        </div>
    </div>

    <div id="emailModal" class="modal">
        <div id="emailModalContent">
            <span id='okienkoZamknij' onClick='zamknijOkienkoWysylaniaWiadomosci()' class="close">&times;</span>
            <form id="emailForm" method="POST" action="Scripts/wyslij.php">
                <span class="cszary napis1 gruby">Nowa wiadomość</span><br>
                <span class="cszary napis2 gruby">Odbiorca:</span><br>
                <input style="width:95%; padding:4px;" placeholder="Odbiorca" class="napis3 cszary" type="text"
                    id="recipients" name="odbiorca"><br><br>
                <span class="cszary napis2 gruby">Temat:</span><br>
                <input style="width:95%; padding:4px;" placeholder="Temat wiadomości" class="napis3 cszary" type="text"
                    id="subject" name="temat"><br><br>
                <span class="cszary napis2 gruby">Treść:</span><br>
                <textarea style="width:95%; padding:7px;" placeholder="Tutaj wpisz swoją wiadomość"
                    class="napis3 tekstarela cszary" id="message" name="wiadomosc" rows="10"
                    cols="100"></textarea><br><br>
                <input type="submit" class="optionD napis2 cczarny" value="Wyślij" style="width:14%; border:none;" />
            </form>
        </div>
    </div>

</body>
</html>
<script>
    const checkboxes = document.querySelectorAll('.zaznaczanie');
    const opcje = document.getElementById('opcje');
    opcje.style.visibility = 'hidden';
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const checked = document.querySelectorAll('.zaznaczanie:checked').length > 0;
            if (checked) {
                opcje.style.visibility = 'visible';
            } else {
                opcje.style.visibility = 'hidden';
            }
        });
    });
</script>

<script>
    var wiadomosci = document.querySelectorAll(".wiadomosc");
    wiadomosci.forEach(function(wiad) {
        wiad.addEventListener("click", function(event) {
            if (!event.target.classList.contains('zaznaczanie')) {
                var idW = this.querySelector(".idW").value;
                window.location.href = 'panel?tryb=8&wiad=' + idW;
            }
        });
    });
</script>

<script>
    var wiadomosci = document.querySelectorAll(".wiadomoscZgloszenia");
    wiadomosci.forEach(function(wiad) {
        wiad.addEventListener("click", function(event) {
            if (!event.target.classList.contains('zaznaczanie')) {
                var idW = this.querySelector(".idW").value;
                window.location.href = 'panel?tryb=13&wiad=' + idW;
            }
        });
    });
</script>

<script>
    function resetForm() {
        var form = document.getElementById('emailForm');
        var inputs = form.getElementsByTagName('input');
        document.getElementById('message').value = "";
        for (var i = 0; i < inputs.length - 1; i++) {
            inputs[i].value = '';
        }
    }

    var modal = document.getElementById("emailModal");
    var btn = document.getElementById("createButton");
    var btn2 = document.getElementById("odpisywanie-przycisk");
    var btn3 = document.getElementById("odpisywanie-przycisk-anuluj");
    var btn4 = document.getElementById("odpisywanie-przycisk-zglos");
    var formularz = document.getElementById("odpisywanie-form");
    var wiad = document.getElementById("nowa-wiadomosc");
    var span = document.getElementById("okienkoZamknij");


    function okienkoWysylaniaWlacz() {
        modal.style.display = "block";
        resetForm();
    }

    function wysylanieWiadomosci() {
        formularz.style.display = "block";
        btn2.style.display = "none";
        btn3.style.display = "none";
        btn4.style.display = "none";
        formularz.value="";
        wiad.select();
        document.body.scrollIntoView({ behavior: 'smooth', block: 'end' });
    }

    function zamknijOkienkoWysylaniaWiadomosci() {
        modal.style.display = "none";
        resetForm();
    }

    function wyslijWiadomosc(login){
        okienkoWysylaniaWlacz();
        var form2 = document.getElementById('emailForm');
        var inputs2 = form2.getElementsByTagName('input');
        inputs2[0].value = login;
    }

</script>

<script>
function konto(){
    window.location.href = 'konto';
}
</script>

<script>
    var przyciskZglos = document.getElementById('odpisywanie-przycisk-zglos');

    function zglosUzytkownika(wiad) {
        var formularz = document.createElement('form');
        formularz.method = 'POST';
        formularz.action = 'Scripts/zglosUzytkownika.php';
        
        var pole1 = document.createElement('input');
        pole1.type = 'hidden';
        pole1.name = 'id';
        pole1.value = wiad;
        formularz.appendChild(pole1);

        document.body.appendChild(formularz);

        formularz.submit();
    }

    function usunWiadomosc(wiad,idOdbiorcy){
        
        var formularz = document.createElement('form');
        formularz.method = 'POST';
        formularz.action = 'Scripts/usunWiadomosc.php';

        var pole1 = document.createElement('input');
        var pole2 = document.createElement('input');

        pole1.type = 'hidden';
        pole2.type = 'hidden';

        pole1.name = 'id';
        pole2.name = 'idOdbiorcy';

        pole1.value = wiad;
        pole2.value = idOdbiorcy;

        formularz.appendChild(pole1);
        formularz.appendChild(pole2);

        document.body.appendChild(formularz);

        formularz.submit();
    }

    function odrzucZgloszenie(id){
        
        var formularz = document.createElement('form');
        formularz.method = 'POST';
        formularz.action = 'Scripts/odrzucZgloszenie.php';

        var pole1 = document.createElement('input');

        pole1.type = 'hidden';

        pole1.name = 'id';

        pole1.value = id;

        formularz.appendChild(pole1);

        document.body.appendChild(formularz);

        formularz.submit();
    }

    function banujUzytkownika(id,idWiad){
        
        var formularz = document.createElement('form');
        formularz.method = 'POST';
        formularz.action = 'Scripts/banujUzytkownika.php';

        var pole1 = document.createElement('input');
        var pole2 = document.createElement('input');

        pole1.type = 'hidden';
        pole2.type = 'hidden';

        pole1.name = 'id';
        pole2.name = 'idW';

        pole1.value = id;
        pole2.value = idWiad;

        formularz.appendChild(pole1);
        formularz.appendChild(pole2);

        document.body.appendChild(formularz);

        formularz.submit();
    }
</script>

<script src="masoweFormularze.js"></script>
<script src="jquery.js"></script>
<script src="ulubione.js"></script>
