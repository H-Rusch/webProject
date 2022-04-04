<?php
include_once "./DAO/config.php";
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <?php
    include_once "./includes/klaro.php";
    ?>
    <!-- JQuery -->
    <script src="../javascript/jquery.js"></script>
    <script>
        $(document).ready(function() {
            $("#map-hint").hide();
        });
    </script>
</head>

<body>
    <!--- Header navigation include-->
    <?php
    include "./includes/nav.php";
    ?>

    <main>
        <section class="text-content">
            <h2>Willkommen auf dieser Mario Kart 8 Guide Website</h2>
            <p class="text-content">
                Diese Website bietet eine Plattform Guides zu Mario Kart 8 zu erstellen und zu bewerten. 
                Es können dabei Guides für Zeitfahren oder für den Online-Modus erstellt werden.
            </p>
        </section>
    </main>

    <!--- footer bar include-->
    <?php
    include "./includes/footer.php";
    ?>
</body>

</html>