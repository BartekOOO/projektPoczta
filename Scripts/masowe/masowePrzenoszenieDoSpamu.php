<?php
session_start();
    $login = $_SESSION['login'];
    $polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");
    $dane = $_POST['dane'];
    $id = $_SESSION['id'];
    echo $dane;
    $tabela = explode(";", $dane);  

    foreach($tabela as $idW){
        $zapytanie = mysqli_query($polaczenie,"SELECT * FROM Watki WHERE id=$idW;");
        while($wiersz=mysqli_fetch_array($zapytanie)){
            if($wiersz['idNadawcy']==$id){
                mysqli_query($polaczenie,"UPDATE Watki SET nadawcaSpam='1', nadawcaKosz='0' WHERE id=$idW;");
            }else if($wiersz['idOdbiorcy']==$id){
                mysqli_query($polaczenie,"UPDATE Watki SET odbiorcaSpam='1', odbiorcaKosz='0' WHERE id=$idW;");
            }
        }
    }

    mysqli_close($polaczenie);

    header("Location: ../../panel?tryb=3");
    exit();
?>