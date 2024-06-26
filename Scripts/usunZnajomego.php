<?php
$id = $_POST['id'];
$idZnajomego = $_POST['idZnajomego'];

$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");
mysqli_query($polaczenie,"DELETE FROM Znajomi WHERE idUzytkownika=$id AND idZnajomego=$idZnajomego");
mysqli_query($polaczenie,"DELETE FROM Znajomi WHERE idUzytkownika=$idZnajomego AND idZnajomego=$id");

mysqli_close($polaczenie);

header("Location: ../panel?tryb=6");
exit();
?>