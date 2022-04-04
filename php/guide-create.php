<?php
include_once "./DAO/config.php";

include_once "./includes/redirect-to-login-script.php";

if (isset($_REQUEST["guideID"])) {
    // get the guide from the database, but if an exception occurs when communication with the database, redirect the user away and show an error message
    try {
        $guide = $dao->getGuide($_REQUEST["guideID"]);
    } catch (PDOException $e) {
        $_SESSION["databaseError"] = "Bei der Kommunikation mit der Datenbank ist ein Fehler aufgetreten.";
    }

    // check if the guide is found (it could have been deleted in the meantime), and if it was, show an error page
    if (!isset($guide)) {
        http_response_code(404);
        die();
    }

    // don't allow users to edit a guide that is not theirs
    if ($guide->getAuthor() != $_SESSION["userID"]) {
        http_response_code(403);
        die();
    }

    $guideID = $guide->getGuideID();
    $category = $guide->getCategory();
    $title = $guide->getTitle();
    $guideText = $guide->getText();

    $trackName = $dao->getTrackNamesForTrack($guide->getTrack())["trackName"];

    $tagText = "";
    $tags = $guide->getTags();
    for ($i = 0; $i < sizeof($tags); $i++) {
        if ($i == count($tags) - 1) {
            $tagText .= $tags[$i][0];
        } else {
            $tagText .= $tags[$i][0] . ", ";
        }
    }
}
$token = $_SESSION["token"];
$submit_to = isset($guide) ? "./logic/edit-guide.php?token=$token&pretty" : "./logic/create-guide.php?pretty";
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <title><?php echo (isset($guide) ? "Guide bearbeiten" : "Guide erstellen") ?></title>
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
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
        <form class="create-guide" method="post" action="<?= $submit_to ?>">
            <?php if (isset($guideID)) : ?>
                <input type="hidden" name="guideID" value="<?= $guideID ?>">
            <?php endif; ?>

            <div class="create-guide-metadata">
                <!-- Category: time-trial/ online -->
                <div class="create-guide-metadata-element">
                    <h2>Guidekategorie</h2>
                    <div class="create-guide-category-overview">
                        <div class="guide-filter-option">
                            <input type="radio" id="time-trial" name="category" value="time-trial" required <?php echo (isset($category) && $category == "time-trial") ? "checked" : "" ?>>
                            <label for="time-trial">Zeitfahren</label>
                        </div>
                        <div class="guide-filter-option">
                            <input type="radio" id="online" name="category" value="online" <?php echo (isset($category) && $category == "online") ? "checked" : "" ?>>
                            <label for="online">Onlinespiel</label>
                        </div>
                    </div>
                </div>

                <!-- Track selection -->
                <div class="create-guide-metadata-element">
                    <h2>Streckenauswahl</h2>
                    <div>
                        <select id="track" name="track">
                            <!-- Fill the track dropdown menu with the tracks from the database. If the guide is being edited, select the value of the current track. -->
                            <?php foreach ($dao->getAllTrackNames() as $track) { ?>
                                <option value="<?php echo $track["trackName"] ?>" <?php if (isset($track["trackName"]) && isset($trackName) && $track["trackName"] == $trackName) {
                                                                                        echo "selected";
                                                                                    } ?>>
                                    <?php echo $track["trackName"] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="create-guide-data">
                <!-- Title -->
                <div class="create-guide-data-element">
                    <label for="title">Titel</label><br>
                    <input id="title" type="text" name="title" maxlength="50" required value="<?php echo (isset($title)) ? $title : "" ?>">
                </div>

                <!-- Guide Text -->
                <div class="create-guide-data-element" id="content">
                    <label for="text">Dein Guide</label><br>
                    <textarea id="text" name="text" required><?php echo (isset($guideText)) ? $guideText : "" ?></textarea>
                    <p class="text-hint">
                        Dieser Editor unterstützt Parsedown für die Textformatierung.
                        <br>
                        Lerne zum Beispiel bei <a href="https://commonmark.org/help/">https://commonmark.org/help/</a> wie du Text formatieren kannst.
                    </p>
                </div>

                <!-- Tags -->
                <div class="create-guide-data-element">
                    <label for="tags">Tags</label><br>
                    <input id="tags" type="text" name="tags" title="Tags durch Komma getrennt hinzufügen" value="<?php echo ($tagText ?? "") ?>">
                </div>

                <button name="publish">Veröffentlichen</button>
            </div>
        </form>
    </main>

    <!--- footer bar include-->
    <?php
    include "./includes/footer.php";
    ?>
</body>

</html>