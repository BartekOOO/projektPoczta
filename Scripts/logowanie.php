<?php

$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");

$login = $_POST['login'];
$haslo = $_POST['haslo'];

$zapytanie = mysqli_query($polaczenie,"SELECT * FROM Uzytkownicy WHERE login='$login' AND haslo='$haslo';");

while($wiersz = mysqli_fetch_array($zapytanie)){
    session_start();
    $_SESSION['login'] = $wiersz['login'];
    $_SESSION['haslo'] = $wiersz['haslo'];
    $_SESSION['admin'] = $wiersz['admin'];
    $_SESSION['bog'] = $wiersz['bog'];
    $_SESSION['id'] = $wiersz['id'];
    $_SESSION['zablokowany']=$wiersz['zablokowany'];
    if($wiersz['zablokowany']==1){
        header("Location: ../kontoZablokowane");
        exit();
    }
    header("Location: ../panel");
    exit();
}

header("Location: ../logowanie?blad=1");
exit();

mysqli_close($polaczenie);

echo "Czemu to widzisz?"

?>