<?php
include_once "./DAO/config.php";
include_once "./logic/validation.php";

// redirect logged in user to home-page
if (isset($_SESSION["userID"])) {
    header("Location: ./home.php");
}

// alerts showing the user some of the input-values have errors 
$errors = ($_SESSION["loginErrors"] ?? []);
unset($_SESSION["loginErrors"]);

// alert showing something went wrong when communicating with the database
if (isset($_SESSION["databaseError"])) {
    $databaseError = $_SESSION["databaseError"];
    unset($_SESSION["databaseError"]);
}

// fill input fields with values of past attempt
$username = ($_SESSION["loginInput"] ?? "");
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png">
    <link rel="stylesheet" href="../styles/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <?php
    include_once "./includes/klaro.php";
    ?>
</head>

<body>
<!--- Header navigation include-->
<?php
include "./includes/nav.php";
?>
<main class="flex-container-vertical">
    <?php 
        include "./includes/database-error.php";
    ?>
    <form class="login-register-dialog" method="post" action="./logic/login-user.php?pretty">
        <h1>Anmelden</h1>

        <label for="username">Nutzername</label>
        <input id="username" name="username" autocomplete="username" title="" required autofocus
            value="<?php echo $username ?>">

        <label for="password">Passwort</label>
        <input id="password" name="password" type="password" autocomplete="current-password"
               title="" required value="">

        <button id="signin" name="submit" class="button-basic">Anmelden</button>
        <?php
        if (sizeof($errors) != 0) {
            ?>
            <p class="text-hint" style="color: red;">
                <?php
                foreach ($errors as $error) {
                    echo "<br> $error";
                }
                ?>
            </p>
            <?php
        }
        ?>
    </form>
    <div class="register-text-hint">
        <p>Noch kein Konto?</p>
        <a href="./register.php">Konto erstellen</a>
    </div>

</main>
<!--- footer bar include-->
<?php
include "./includes/footer.php";
?>
</body>
</html>