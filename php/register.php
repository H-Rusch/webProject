<?php
include_once "./DAO/config.php";

// redirect logged in user to home-page
if (isset($_SESSION["userID"])) {
    header("Location: home.php");
}

// alerts showing user input was not valid
$errors = ($_SESSION["registrationErrors"] ?? []);
unset($_SESSION["registrationErrors"]);

// alert showing something went wrong when communicating with the database
if (isset($_SESSION["databaseError"])) {
    $databaseError = $_SESSION["databaseError"];
    unset($_SESSION["databaseError"]);
}

// fill input fields with values of past attempt
$username = (isset($_SESSION["registrationInput"]) ? $_SESSION["registrationInput"][0] : "");
$email = (isset($_SESSION["registrationInput"]) ? $_SESSION["registrationInput"][1] : "");
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Registrieren</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png">
    <link rel="stylesheet" href="../styles/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <!-- JQuery -->
    <script src="../javascript/jquery.js"></script>   
    <script src="../javascript/register-validation.js"></script>
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
    <form class="login-register-dialog" method="post" action="./logic/register-user.php?pretty">
        <h1>Registrieren</h1>

        <label for="username">Nutzername</label>
        <input id="username" name="username" autocomplete="username" title="" required autofocus
               value="<?php echo $username; ?>">

        <label for="new-password">Passwort</label>
        <input id="new-password" name="new-password" type="password" autocomplete="new-password" title="" required>

        <label for="confirm-new-password">Passwort wiederholen</label>
        <input id="confirm-new-password" name="confirm-new-password" type="password" title="" required>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" autocomplete="email" required value="<?php echo $email; ?>">

        <button type="submit" id="signin" name="submit" class="button-basic">Konto erstellen</button>

        <!-- Hint text which shows up if the user submitted wrong values -->
        <?php
        if (sizeof($errors) != 0) {
        ?>
            <p class="text-hint error-text">
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
</main>
<!--- footer bar include-->
<?php
include "./includes/footer.php";
?>
</body>
</html>