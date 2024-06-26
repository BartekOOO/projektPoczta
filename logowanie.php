<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="Styles/fonty.css">
    <link rel="stylesheet" href="Styles/style1.css">
    <link href="Styles/podstawa.css" rel="stylesheet">
    <link rel="icon" href="Images/p.png" type="image/png">
</head>
<body>
    <div id="srodek">
        <div class="container">
            <form method="POST" action="Scripts/logowanie.php">
                <span class="napis1">Logowanie</span><br><br>
                <input class="szary" type="text" placeholder="Login" name="login"><br><br><br>
                <input class="szary" id="inp" type="password" placeholder="Hasło" name="haslo"><br>
                <span>Pokaż hasło </span><input id="zaz" onchange="zmien()" type="checkbox"><br><br>
                <input type="submit" value="Zaloguj się"><br><br>
                <span class="czerwony napis2"><?php if(!empty($_GET['blad'])){ echo "Niepoprawne dane logowania"; } ?></span>
                <br><br>
                <span><u><a style="text-decoration:none; color:blue;" href="rejestracja">Nie masz konta? Zarejestruj się</a></u></span>
            </form>
        </div>
    </div>
</body>
</html>

<script>
    var czy_tekst = false;
    const inp = document.getElementById("inp");
function zmien(){
    if(czy_tekst){
        czy_tekst = false;
        inp.type="password";
    }
    else{
        inp.type="text";
        czy_tekst = true;
    }
}
</script>