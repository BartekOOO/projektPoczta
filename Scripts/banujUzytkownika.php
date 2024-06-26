<?php


$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");

$id = $_POST['id'];
$idW = $_POST['idW'];

mysqli_query($polaczenie,"UPDATE Zgloszenia SET rozpatrzono='1' WHERE idWatku=$idW;");
mysqli_query($polaczenie,"UPDATE Uzytkownicy SET zablokowany='1' WHERE id=$id AND admin='0' AND bog='0';");



mysqli_close($polaczenie);

header("Location: ../panel?tryb=12");
exit();

?>