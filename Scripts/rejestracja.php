<?php
$login = $_POST['login'];

$haslo1 = $_POST['haslo1'];
$haslo2 = $_POST['haslo2'];

$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$dataUrodzenia = $_POST['dataUrodzenia'];
$numertelefonu = $_POST['numerTelefonu'];
$adres = $_POST['adres'];

$dataZalozeniaKonta = date("Y-m-d");

if(empty($login)||empty($haslo1)||empty($haslo2)||empty($imie)||empty($nazwisko)||empty($dataUrodzenia)||empty($numertelefonu)||empty($adres)){
    header("Location: ../rejestracja?blad=Nie%20uzupe%C5%82ni%C5%82e%C5%9B%20wszystkich%20p%C3%B3l");
    exit();
}

if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{11,}$/', $haslo1)) {
    header("Location: ../rejestracja?blad=Hasło%20musi%20zawierać%20minimum%2010%20znaków%2C%20jedną%20małą%20i%20wielką%20literę%20oraz%20cyfrę");
    exit();
}

if (!preg_match('/@poczta\.pl$/', $login)) {
    header("Location: ../rejestracja?blad=Z%C5%82a%20sk%C5%82adnia%20adresu%20email");
    exit();
}


if (!preg_match('/^\d{9}$/', $numertelefonu)) {
    header("Location: ../rejestracja?blad=B%C5%82%C4%99dny%20numer%20telefonu");
    exit();
}


$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");
$zapytanie = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE login='$login';");

while($wiersz=mysqli_fetch_array($zapytanie)){
    if($wiersz['login']==$login){
        header("Location: ../rejestracja?blad=Użytkownik%20ju%C5%BC%20istnieje");
        exit();
    }
}

if($haslo1!=$haslo2){
    header("Location: ../rejestracja?blad=Podane%20has%C5%82a%20s%C4%85%20r%C3%B3%C5%BCne");
    exit();
}

mysqli_query($polaczenie,"INSERT INTO Uzytkownicy (login,haslo,imie,nazwisko,dataUrodzenia,numerTelefonu,adres,dataZalozeniaKonta,ukryteKonto,admin,bog) VALUES ('$login','$haslo1','$imie','$nazwisko','$dataUrodzenia','$numertelefonu','$adres','$dataZalozeniaKonta','0','0','0');");

mysqli_close($polaczenie);

session_start();
$_SESSION['login'] = $login;
$_SESSION['haslo'] = $haslo1;
header("Location: ../panel");
exit();

?>