<?php

$id = $_POST['id'];
$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$dataUrodzenia = $_POST['dataUrodzenia'];
$adres = $_POST['adres'];
$numerTelefonu = $_POST['numerTelefonu'];


if(empty($imie)||empty($nazwisko)||empty($dataUrodzenia)||empty($adres)){
    header("Location: ../konto");
    exit();
}

if (!preg_match('/^\d{9}$/', $numerTelefonu)) {
    header("Location: ../konto?blad=B%C5%82%C4%99dny%20numer%20telefonu");
    exit();
}

$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");

mysqli_query($polaczenie,"UPDATE Uzytkownicy SET numerTelefonu='$numerTelefonu', imie='$imie', nazwisko='$nazwisko', dataUrodzenia='$dataUrodzenia', adres='$adres' WHERE id='$id';");


mysqli_close($polaczenie);
header("Location: ../konto");
exit();

?>