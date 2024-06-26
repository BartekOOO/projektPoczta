<?php

$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");

$trybZapraszania = $_POST['trybZapraszania'];
$idZapraszajacego = $_POST['idZapraszajacego'];
$idZapraszanego = $_POST['idZapraszanego'];


if($trybZapraszania=='1'){

mysqli_query($polaczenie,"INSERT INTO Zaproszenia (idZapraszajacego,idZaproszonego) VALUES ($idZapraszajacego,$idZapraszanego);");
}else if($trybZapraszania=='2'){


mysqli_query($polaczenie,"INSERT INTO Znajomi (idUzytkownika, idZnajomego) VALUES ($idZapraszajacego,$idZapraszanego);");
mysqli_query($polaczenie,"INSERT INTO Znajomi (idUzytkownika, idZnajomego) VALUES ($idZapraszanego,$idZapraszajacego);");
mysqli_query($polaczenie,"DELETE FROM Zaproszenia WHERE idZapraszajacego=$idZapraszajacego AND idZaproszonego=$idZapraszanego;");
mysqli_query($polaczenie,"DELETE FROM Zaproszenia WHERE idZapraszajacego=$idZapraszanego AND idZaproszonego=$idZapraszajacego;");

}

mysqli_close($polaczenie);
header("Location: ../panel?tryb=10");
exit();
?>