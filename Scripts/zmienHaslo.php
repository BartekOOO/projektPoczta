<?php

$stare = $_POST['haslo'];
$haslo1 = $_POST['haslo1'];
$haslo2 = $_POST['haslo1'];

if(empty($stare)||empty($haslo1)||empty($haslo2)){
    header("Location: ../zmianaHasla?blad=Nie%20uzupe%C5%82ni%C5%82e%C5%9B%20wszystkich%20p%C3%B3l");
    exit();
}


if($haslo1!=$haslo2){
    header("Location: ../zmianaHasla?blad=Podane%20has%C5%82a%20s%C4%85%20r%C3%B3%C5%BCne");
    exit();
}

if($haslo1==$stare){
    header("Location: ../zmianaHasla?blad=Pr%C3%B3bujesz%20ustawi%C4%87%20stare%20has%C5%82o%20jako%20nowe%3F");
    exit();
}

if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{11,}$/', $haslo1)) {
    header("Location: ../zmianaHasla?blad=Hasło%20musi%20zawierać%20minimum%2010%20znaków%2C%20jedną%20małą%20i%20wielką%20literę%20oraz%20cyfrę");
    exit();
}

session_start();

if($stare!=$_SESSION['haslo']){
    header("Location: ../zmianaHasla?blad=B%C5%82%C4%99dne%20has%C5%82o");
    exit();
}

$login = $_SESSION['login'];

$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");
mysqli_query($polaczenie,"UPDATE Uzytkownicy SET haslo='$haslo1' WHERE login='$login';");
$_SESSION['haslo']=$haslo1;
mysqli_close($polaczenie);

header("Location: ../konto");
exit();

?>