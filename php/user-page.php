<?php
include_once "./DAO/config.php";

include_once "./includes/redirect-to-login-script.php";

// alert showing something went wrong when communicating with the database
if (isset($_SESSION["databaseError"])) {
    $databaseError = $_SESSION["databaseError"];
    unset($_SESSION["databaseError"]);
}

// search guides based on the given parameters
if (isset($_REQUEST["search"])) {
    $search = $_REQUEST["search"];
    $guides = $dao->searchGuide($search, $_SESSION["userID"]);
} else {
    $search = "";
    $guides = $dao->getGuidesForUser($_SESSION["userID"]);
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Nutzer</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <!-- JQuery -->
    <script src="../javascript/jquery.js"></script>
    <script src="../javascript/user-page-entries.js"></script>
    <?php
    include_once "./includes/klaro.php";
    ?>
</head>


<body>
<!--- Header navigation include-->
<?php
include "./includes/nav.php";
?>

<main>
    <?php 
        include "./includes/database-error.php";
    ?>
    <input type="hidden" id="userID" value="<?php echo $_SESSION["userID"] ?>">
    <input type="hidden" id="token" value="<?php echo $_SESSION["token"] ?>">

    <div class="guide-overview">
        <div class="profile-buttons">
            <a href="./logic/logout-user.php" id="logout-button" class="button-basic link-button">Logout</a>
        </div>
        <h2>Deine Guides</h2>
        <form>
            <label for="search-guide" class="hidden-label">Suchleiste</label>
            <input id="search-guide" class="search-bar guide-overview-entry" type="search" name="search"
                   placeholder="Suche... (besser mit JavaScript)" value="<?= $search ?>">
            <script>
                // self executing function
                (function() {
                   document.getElementById("search-guide").placeholder = "Suche..."
                })();
            </script>
        </form>
        <div id="guides" class="user-page-entry">
            <!-- load users guides -->
            <?php foreach($guides as $guide): ?>
                <?php include "./includes/guide-link.php"; ?>
                <a class="button-basic link-button confirm-delete"
                    href="./logic/delete-guide.php?guideID=<?= $guide["guideID"] ?>&token=<?php echo $_SESSION["token"] ?>&pretty">Löschen</a>
                <a class="button-basic link-button" 
                    href="./guide-create.php?guideID=<?= $guide["guideID"] ?>">Bearbeiten</a>
            <?php endforeach; ?>
            <?php if (empty($guides)): ?>
                <p class="error-text">Es sind keine Guides verfügbar.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<!--- footer bar include-->
<?php
include "./includes/footer.php";
?>
</body>
</html>
