<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="Styles/fonty.css">
    <link rel="stylesheet" href="Styles/style1.css">
    <link rel="stylesheet" href="Styles/daty.css">
    <link href="Styles/podstawa.css" rel="stylesheet">
    <link rel="icon" href="Images/p.png" type="image/png">
</head>
<body>
    <div id="srodek">
        <div class="containerR">
            <form method="POST" action="Scripts/rejestracja.php">
                <span class="napis1">Witamy w panelu rejestracji</span><br><br>
                <span class="napis2">Wypełnij poniższy formularz:</span><br><br>
                    <input style="width:50%;" type="text" placeholder="Email@poczta.pl" name="login">
                    <br><br>
                    <input style="width:40%;" type="text" placeholder="Imie" name="imie">
                    <input style="width:40%;" type="text" placeholder="Nazwisko" name="nazwisko">
                    <br><br>
                    <span class="napis3 cszary">Data urodzenia:</span>
                    <input type="date" style="width:30%;" placeholder="Data Urodzenia" name="dataUrodzenia">
                    <br><br>
                    <input type="text" style="width:40%;" placeholder="Numer Telefonu" name="numerTelefonu">
                    <input type="text" style="width:40%;" placeholder="Adres" name="adres">
                    <br><br>
                    <input type="password" style="width:40%;" placeholder="Podaj hasło" name="haslo1">
                    <input type="password" style="width:40%;" placeholder="Powtórz hasło" name="haslo2"><br><br><br>
                    <input type="submit" style="margin-right:15px;" value="Zarejestruj się"><a href="logowanie"><input value="Powrót" type="button"></a><br>
                    <span class="napis3 czerwony"><?php if(!empty($_GET['blad'])){ echo $_GET['blad']; } ?></span>
                    <br>
            </form>
        </div>
    </div>
</body>
</html>