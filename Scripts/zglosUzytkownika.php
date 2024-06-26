<?php

$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");
$id = $_POST['id'];
mysqli_query($polaczenie,"INSERT INTO Zgloszenia (idWatku,rozpatrzono) VALUES ($id,'0');");

mysqli_close($polaczenie);

header("Location: ../panel");
exit();
?>