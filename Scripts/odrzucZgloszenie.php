<?php
$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");

$id = $_POST['id'];

mysqli_query($polaczenie,"UPDATE Zgloszenia SET rozpatrzono='1' WHERE idWatku=$id;");



mysqli_close($polaczenie);

header("Location: ../panel?tryb=12");
exit();

?>