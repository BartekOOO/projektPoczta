<?php


$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");

$id = $_POST['idAdmina'];


mysqli_query($polaczenie,"UPDATE Uzytkownicy SET admin='0' WHERE id=$id;");



mysqli_close($polaczenie);

header("Location: ../panel?tryb=15");
exit();

?>