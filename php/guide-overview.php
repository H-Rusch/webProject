<?php
include_once "./DAO/config.php";

// batch of guides to be shown on a page in pagination
if (isset($_REQUEST['batch'])) {
    $batch = $_REQUEST['batch'];
} else {
    $batch = 0;
}

// search guides with the specified search term
if (isset($_REQUEST["search"])) {
    $search = $_REQUEST["search"];
    $guides = $dao->searchGuide($search, null, $batch);
} else {
    $search = "";
    $guides = $dao->getGuides($batch);
}

if (isset($_SESSION["guideCreatedMessage"])) {
    $guideCreatedMessage = $_SESSION["guideCreatedMessage"];
    unset($_SESSION["guideCreatedMessage"]);
}

if (isset($_REQUEST["sortBy"])) {
    $guides = $dao->sortGuides($guides, $_REQUEST["sortBy"]);
}

$hasPrevBatch = $batch > 0;
$hasNextBatch = !empty($guides);

// alert showing something went wrong when communicating with the database
if (isset($_SESSION["databaseError"])) {
    $databaseError = $_SESSION["databaseError"];
    unset($_SESSION["databaseError"]);
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Guide-Übersicht</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
    <!-- JQuery -->
    <script src="../javascript/jquery.js"></script>   
    <script src="../javascript/guide-overview-entries.js"></script>
    <?php
    include_once "./includes/klaro.php";
    ?>
</head>

<body>
<!--- Header navigation include-->
<?php
include "./includes/nav.php";
?>
<?php 
    include "./includes/database-error.php";
?>
<main class="guide-overview-container">
    <form class="guide-filter-overview">
        <h2>Sortieren</h2>

        <noscript>
            <div class="guide-filters">
            <a class="button-basic category-button" id="lastEdit" href="?search=<?= $search ?>&batch=<?= $batch?>&sortBy=lastEdit">Aktualität</a>
            <a class="button-basic category-button" id="category" href="?search=<?= $search ?>&batch=<?= $batch?>&sortBy=category">Kategorie</a>
            </div>
        </noscript>

    </form>
    <script>
    (function() {
    document.getElementsByClassName("guide-filters").outerHTML = "";
    })();
    </script>

    <div class="guide-overview">
        <?php
        if (isset($guideCreatedMessage)) {
            ?>
        <p class="guide-created-text">
             <?php echo $guideCreatedMessage;?>
        </p>
        <?php
        }
        ?>
        <h2>Guideübersicht</h2>
        <a href="./guide-create.php" class="guide-overview-entry new-guide-button">
            neuen Guide erstellen
        </a>
        <form>
            <label for="search-guide" class="hidden-label">Suchleiste</label>
            <input id="search-guide" class="search-bar guide-overview-entry" type="search" name="search"
                   placeholder="Suche... (besser mit JavaScript)" value="<?=$search?>">
            <script>
                // self executing function
                (function() {
                   document.getElementById("search-guide").placeholder = "Suche..."
                })();
            </script>
        </form>
        <div id="guides">
            <?php foreach($guides as $guide) {
                include "./includes/guide-link.php";
            }?>
        </div>

        <?php if (empty($guides)): ?>
                <p class="error-text">Es sind keine weiteren Guides verfügbar.</p>
            <?php endif; ?>
            <noscript>
                <div id="pagination">
                    <?php if ($hasPrevBatch): ?>
                        <a class="button-basic link-button" href="?search=<?= $search ?>&batch=<?= $batch - 1 ?>">Vorherige Seite</a>
                    <?php endif; ?>
                    <?php if ($hasNextBatch): ?>
                        <a class="button-basic link-button" href="?search=<?= $search ?>&batch=<?= $batch + 1 ?>">Nächste Seite</a>
                    <?php endif; ?>
                    <span>Besser mit JavaScript</span>
                </div>
            </noscript>
            <script>
                // self executing function to remove pagination buttons
                (function() {
                    $("#pagination").hide();
                })();
            </script>

    </div>
</main>

<!--- footer bar include-->
<?php
include "./includes/footer.php";
?>
</body>
</html>
