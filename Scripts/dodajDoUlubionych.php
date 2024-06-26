<?php
session_start();
 $idWatku = $_REQUEST["idWatku"];
 $idUzytkownika = $_SESSION["id"];


$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");
$tryb=false;

 $sql = mysqli_query($polaczenie,"SELECT * FROM ulubione WHERE idWatku = $idWatku AND idUzytkownika = $idUzytkownika;");
while($wiersz=mysqli_fetch_array($sql)){
    $tryb=true;
}

if($tryb){
    mysqli_query($polaczenie,"DELETE FROM ulubione WHERE idWatku = $idWatku AND idUzytkownika = $idUzytkownika;");
}else{
    mysqli_query($polaczenie,"INSERT INTO ulubione (idWatku,idUzytkownika) VALUES ('$idWatku','$idUzytkownika');");
}



 mysqli_close($polaczenie);

 
?>