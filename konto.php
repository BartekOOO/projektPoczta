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
    <title><?php echo $_SESSION['login']; ?></title>
    <link rel="stylesheet" href="Styles/fonty.css">
    <link rel="stylesheet" href="Styles/style1.css">
    <link rel="stylesheet" href="Styles/daty.css">
    <link href="Styles/podstawa.css" rel="stylesheet">
    <link rel="icon" href="Images/p.png" type="image/png">
</head>
<body>
    <div id="srodek">
        <div class="containerR">
          <?php  
                $login = $_SESSION['login'];
                $polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");
        
                $zapytanie = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE login='$login';");
                while($wiersz=mysqli_fetch_array($zapytanie)){
                    $idZalogowanego = $wiersz['id'];
                    $haslo = $_SESSION['haslo'];

                    $imie = $wiersz['imie'];
                    $nazwisko = $wiersz['nazwisko'];
                    $dataUrodzenia = $wiersz['dataUrodzenia'];
                    $dataZalozenia = $wiersz['dataZalozeniaKonta'];
                    $numerTelefonu = $wiersz['numerTelefonu'];
                    $adres = $wiersz['adres'];
                }
                
                echo "<form method='POST' action='Scripts/zapiszZmiany.php'>";
                echo "<span class='napis3 cszary'>Login</span><br>";         
                echo "<input name='id' type='hidden' value='$idZalogowanego'>";       
                echo "<input style='width:50%;' value='$login' type='text' disabled placeholder='Email@poczta.pl' name='login'><br><br>";
                echo "<span class='napis3 cszary'>Hasło</span><br>";
                echo "<input style='width:50%;' value='$haslo' disabled type='password' placeholder='Hasło' name='haslo'><br><br><br>";
                echo "<span class='napis3 cszary'>Dane osobowe:</span><br>";
                echo "<input style='width:40%;' value='$imie' type='text' placeholder='Imie' name='imie'>";
                echo "   <input style='width:40%;' value='$nazwisko' type='text' placeholder='Nazwisko' name='nazwisko'><br><br>";

                echo "<span class='napis3 cszary'>Data urodzenia & Miejsce zamieszkania</span><br>";
                echo "<input style='width:40%;' value='$dataUrodzenia' type='date' name='dataUrodzenia'>";
                echo "   <input style='width:40%;' value='$adres' type='text' placeholder='Adres' name='adres'><br><br>";

                echo "<span class='napis3 cszary'>Numer telefonu:</span><br>";                
                echo "<input style='width:40%;' value='$numerTelefonu' type='text' placeholder='Numer telefonu' name='numerTelefonu'><br><br>";

                echo "<input type='submit' class='optionD napis2 cczarny' value='Zapisz zmiany' style='border:none;' /><br>";
                $komunikat="";
                if(!empty($_GET['blad'])){ 
                    $komunikat = $_GET['blad'];
                }
                echo "<span class='napis3 czerwony'>$komunikat</span>";
                echo '</form><br>';

                $zapytanie = mysqli_query($polaczenie,"SELECT COUNT(*) FROM `Wiadomosci` WHERE idNadawcy=$idZalogowanego;");
                while($wiersz=mysqli_fetch_array($zapytanie)){
                    $zmienna1 = $wiersz[0];
                }

                $zapytanie = mysqli_query($polaczenie,"SELECT COUNT(*) FROM `Wiadomosci` WHERE idOdbiorcy=$idZalogowanego;");
                while($wiersz=mysqli_fetch_array($zapytanie)){
                    $zmienna2 = $wiersz[0];
                }

                $zapytanie = mysqli_query($polaczenie,"SELECT COUNT(*) FROM `Znajomi` WHERE idUzytkownika=$idZalogowanego;");
                while($wiersz=mysqli_fetch_array($zapytanie)){
                    $zmienna3 = $wiersz[0];
                }

                $zapytanie = mysqli_query($polaczenie,"SELECT ukryteKonto, admin, bog, dataZalozeniaKonta FROM `Uzytkownicy` WHERE id=$idZalogowanego;");
                while($wiersz=mysqli_fetch_array($zapytanie)){
                    $zmienna4 = $wiersz[0];
                    if($zmienna4){
                        $zmienna4="<span class='czerwony'>Konto ukryte</span>";
                    }
                    else{
                        $zmienna4="<span class='zielony'>Konto widoczne</span>";
                    }
                    $zmienna5=$wiersz[1];
                    $zmienna6=$wiersz[2];
                    if($zmienna5){
                        $zmienna5="<span class='czerwony'>Administrator</span>";
                    }else if($zmienna6){
                        $zmienna5="<span class='niebieski'>Boskie konto</span>";
                    }
                    else{
                        $zmienna5="<span class='zielony'>Użytkownik</span>";
                    }
                    $zmienna6=$wiersz[3];
                }


                echo "<span class='napis2 gruby cszary'>Informacje o koncie:</span><br>";
                echo "<span class='napis3 cszary'>Liczba wysłanych wiadomości: $zmienna1</span><br>";
                echo "<span class='napis3 cszary'>Liczba otrzymanych wiadomości: $zmienna2</span><br>";
                echo "<span class='napis3 cszary'>Liczba znajomych: $zmienna3</span><br>";
                echo "<span class='napis3 cszary'>Status konta: $zmienna4</span><br>";
                echo "<span class='napis3 cszary'>Typ konta: $zmienna5</span><br>";
                echo "<span class='napis3 cszary'>Data dołączenia: $zmienna6</span><br><br>";

                echo "   <input id='zmienStatus' type='submit' class='optionD napis2 cczarny' value='Zmień status konta' style='border:none;' />";
                echo "   <input id='zmienHaslo' type='submit' class='optionD napis2 cczarny' value='Zmień hasło' style='border:none;' />";
                echo "   <input id='powrot' type='submit' class='optionD napis2 cczarny' value='Wróć' style='border:none;' />";

                mysqli_close($polaczenie);
            ?>
        </div>
    </div>
</body>
</html>
<script>
    var powrot = document.getElementById('powrot');
    powrot.addEventListener("click",function(){
        window.location.href="panel?tryb=1";
    });

    var haslo = document.getElementById('zmienHaslo');
    haslo.addEventListener("click",function(){
        window.location.href="zmianaHasla";
    });

    var dostep = document.getElementById('zmienStatus');
    dostep.addEventListener("click",function(){
        window.location.href="Scripts/zmienWidocznosc.php";
    });

</script>