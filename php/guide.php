<?php
include_once "./includes/Parsedown.php";
include_once "./DAO/config.php";

if (isset($_REQUEST["id"]) && is_numeric($_REQUEST["id"])) {
    $guide = $dao->getGuide($_REQUEST["id"]);
}
if (!isset($guide)) {
    http_response_code(404);
    die();
}

if (null !== $guide->getAuthor()) {
    $authorName = $dao->getUsername($guide->getAuthor())[0];
    if (!isset($authorName)) {
        $authorName = "Anonym";
    }
}


$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true);
$text = $Parsedown->text($guide->getText());

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <title>Guide Lesen</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/shariff.min.css">
    <!-- JQuery -->
    <script src="../javascript/jquery.js"></script>
    <!-- custom scripts -->
    <script src="../javascript/like-dislike.js"></script>

    <?php
    include_once "./includes/klaro.php";
    ?>
</head>

<body>
    <!--- Header navigation include-->
    <?php
    include "./includes/nav.php";
    ?>

    <main class="guide-main">
        <input type="hidden" id="userID" value="<?php echo ($_SESSION["userID"] ?? "") ?>">
        <input type="hidden" id="guideID" value="<?php echo $_REQUEST["id"] ?>">
        <input type="hidden" id="token" value="<?php echo ($_SESSION["token"] ?? "") ?>">

        <div class="guide-sidebar">
            <!--- likes and dislikes -->
            <div id="like-dislike-container" class="like-dislike-element">
                <div class="like-dislike-element-internal">
                    <form action="./logic/like-dislike-guide.php?guideID=<?php echo $guide->getGuideID() ?>&pretty" class="like-dislike-element" method="post">
                        <input type="checkbox" id="like" name="like">
                        <input type="hidden" name="token" value="<?php echo ($_SESSION["token"] ?? '') ?>">
                        <label for="like" class="rating-button" id="like-button">Gefällt<br>mir</label>
                        <button type="submit" id="like-submit-button" title="Bestätigen">
                            Bestätigen
                        </button>
                        <p id="like-count"><?php echo $guide->getLikes() ?></p>
                    </form>

                    <form action="./logic/like-dislike-guide.php?guideID=<?php echo $guide->getGuideID() ?>&pretty" class="like-dislike-element" method="post">
                        <input type="checkbox" id="dislike" name="dislike">
                        <input type="hidden" name="token" value="<?php echo ($_SESSION["token"] ?? '') ?>">
                        <label for="dislike" class="rating-button" id="dislike-button">Gefällt<br>mir nicht</label>
                        <button type="submit" id="dislike-submit-button" title="Bestägigen">
                            Bestätigen
                        </button>
                        <p id="dislike-count"><?php echo $guide->getDislikes() ?></p>
                    </form>
                </div>
            </div>

            <a class="button-basic link-button" href="./guide-create.php?guideID=<?= $guide->getGuideID() ?>" <?php if (empty($_SESSION["userID"]) || $guide->getAuthor() != $_SESSION["userID"]) echo "hidden"; ?>>Bearbeiten</a>
        </div>

        <div>
            <section class="text-content guide-text">
                <h1><?php echo $guide->getTitle() ?></h1>
                <!--- General information -->
                <h2 id="track-title"><?php echo $dao->getTrackNamesForTrack($guide->getTrack())["trackName"] ?></h2>
                <p>
                    Von: <label id="author"><strong><?php echo $authorName ?></strong></label>, <br>
                    zuletzt editiert am:
                    <time class="post-meta" datetime="<?php echo date("Y-m-d", $guide->getLastEdited()) ?>">
                        <?php echo date("d.m.Y", $guide->getLastEdited()) ?>
                    </time>
                </p>
                <!-- Guide text -->
                <?php echo $text ?>
            </section>

            <!-- Share buttons using Shariff -->
            <div class="shariff" data-title="<?php echo $guide->getTitle() ?>" data-services="[&quot;facebook&quot;,&quot;twitter&quot;]">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>">Auf Facebook teilen</a>
                <a href="https://twitter.com/intent/tweet?text=<?php echo $guide->getTitle() ?>;url=<?php echo "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>">Auf Twitter teilen</a>
            </div>
        </div>
    </main>

    <!--- footer bar include-->
    <?php
    include "./includes/footer.php";
    ?>
    <script src="../javascript/shariff.min.js"></script>
</body>

</html>