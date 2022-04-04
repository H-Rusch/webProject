<?php
session_start();
$key = $_SESSION["registration_key"];
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
</head>

<body>
    <p>
    Dies wäre in Produktion eine Email.
    </p>

    <p>
    Diese Email-Addresse wurde zur Registrierung bei
    <a href="../">https://mounted-games-spiele.de</a>
    genutzt.
    <br />
    Du kannst diesen link aufrufen,
    um die Registrierung abzuschließen.
    <a href="./logic/register-user-confirm.php?key=<?= $key ?>">https://mounted-games-spiele.de/register/confirm/<?= $key ?></a>
    </p>
</body>
</html>
