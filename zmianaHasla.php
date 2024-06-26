<?php
session_start();
if (!isset($_SESSION['login']) || !isset($_SESSION['haslo'])) {
    session_destroy();
    header("Location: logowanie");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zmiana hasła</title>
    <link rel="stylesheet" href="Styles/fonty.css">
    <link rel="stylesheet" href="Styles/style1.css">
    <link rel="stylesheet" href="Styles/daty.css">
    <link href="Styles/podstawa.css" rel="stylesheet">
    <link rel="icon" href="Images/p.png" type="image/png">
</head>
<body>
    <div id="srodek">
        <div class="containerR">
            <form method="POST" action="Scripts/zmienHaslo.php">
                <span class="napis1">Witamy w panelu zmiany hasła</span><br><br>
                <span class="napis2">Wypełnij poniższe pola aby dokonać zmiany hasła</span><br><br>
                    <input type="password" style="width:40%;" placeholder="Podaj obecne hasło" name="haslo"><br><br>
                    <input type="password" style="width:40%;" placeholder="Podaj nowe hasło" name="haslo1">
                    <input type="password" style="width:40%;" placeholder="Powtórz nowe hasło" name="haslo2"><br><br><br>
                    <input type="submit" style="margin-right:15px;" value="Zmień hasło"><a href="../konto"><input value="Powrót" type="button"></a><br>
                    <span class="napis3 czerwony"><?php if(!empty($_GET['blad'])){ echo $_GET['blad']; } ?></span>
                    <br>
            </form>
        </div>
    </div>
</body>
</html>