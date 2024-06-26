<?php
    session_start();
    $polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");

    $login = $_SESSION['login'];

    mysqli_query($polaczenie, "UPDATE Uzytkownicy SET ukryteKonto = IF(ukryteKonto=1, 0, 1) WHERE login='$login';");

    header("Location: ../konto");
    exit();
?>