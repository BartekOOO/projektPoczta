<?php

$idWatku = $_POST['id'];
$idOdbiorcy = $_POST['idOdbiorcy'];


$polaczenie = new mysqli("mysql.ct8.pl","m43842_admin","Bazadanych1234","m43842_Poczta");


$zapytanie = mysqli_query($polaczenie,"SELECT * FROM Watki WHERE id=$idWatku;");
while($wiersz=mysqli_fetch_array($zapytanie)){
    if($wiersz['idOdbiorcy']==$idOdbiorcy&&$wiersz['idNadawcy']==$idOdbiorcy){
        mysqli_query($polaczenie,"UPDATE Watki SET odbiorcaWidzi = '0', nadawcaWidzi='0' WHERE id=$idWatku;");
        mysqli_query($polaczenie,"UPDATE Wiadomosci SET odbiorcaWidzi = '0', nadawcaWidzi='0' WHERE idWatku=$idWatku;");
    }
    else if($wiersz['idOdbiorcy']!=$idOdbiorcy){
        mysqli_query($polaczenie,"UPDATE Watki SET odbiorcaWidzi = '0' WHERE id=$idWatku;");
        mysqli_query($polaczenie,"UPDATE Wiadomosci SET odbiorcaWidzi = '0' WHERE idWatku=$idWatku;");
    }
    else{
        mysqli_query($polaczenie,"UPDATE Watki SET nadawcaWidzi = '0' WHERE id=$idWatku;");
        mysqli_query($polaczenie,"UPDATE Wiadomosci SET nadawcaWidzi = '0' WHERE idWatku=$idWatku;");    }
}



mysqli_close($polaczenie);

header("Location: ../panel");
exit();
?>