<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ładowanie</title>
</head>
<body>
<?php
session_start();
if (isset($_SESSION['login']) && isset($_SESSION['haslo'])) {
    header("Location: panel");
    exit();
} else {
    header("Location: logowanie");
    exit();
}
?>
Witam witam!
</body>
</html>
