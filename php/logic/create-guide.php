<?php
/*
 * Endpoint to create a guide.
 *
 * # Parameters
 * - 'pretty': GET/POST optional flag
 *     Without 'pretty' this acts like a rest api endpoint
 *     with useful feedback in plain text.
 *     For the website 'pretty' should be set.
 * - 'title': POST required string
 * - 'text': POST required string
 *     The content of the guide in Markdown syntax.
 * - 'track': POST required string
 *     The track name, for example 'Rainbow Road'.
 * - 'category': POST required string
 *     One of ["time-trial", "online"]
 * - 'tags': POST required comma-separated list of strings
 *     Tags are invisible. They enhance search results.
 */

include_once "../DAO/config.php";

$pretty = isset($_REQUEST["pretty"]);
if (isset($_SESSION["userID"])) {
    $user_id = $_SESSION["userID"];
} else {
    if ($pretty) {
        header("Location: ../login.php");
    } else {
        http_response_code(401);
        echo "you must be logged in to create a guide";
    }
}

if (isset($_POST['title'])) {
    $title = htmlentities($_POST['title']);
} else {
    /* should never happen with the client -> no pretty error */
    http_response_code(400);
    echo "missing required parameter 'title'";
    die();
}

if (isset($_POST['text'])) {
    $text = $_POST['text'];
} else {
    /* should never happen with the client -> no pretty error */
    http_response_code(400);
    echo "missing required parameter 'text'";
    die();
}

if (isset($_POST['track'])) {
    $track_name = $_POST['track'];
} else {
    /* should never happen with the client -> no pretty error */
    http_response_code(400);
    echo "missing required parameter 'track'";
    die();
}
try {
    $track_id = $dao->getTrackIdByName($track_name);
    if ($track_id == null) {
        /* should never happen with the client -> no pretty error */
        http_response_code(400);
        echo "no track with that name exists";
        die();
    }
} catch(PDOException $e) {
    if ($pretty) {
        $_SESSION["databaseError"] = "Ein unerwarteter Fehler ist aufgetreten.";
        header("Location: ../user-page.php");
    } else {
        http_response_code(500);
        echo "could not create the guide for an unexpected reason";
    }
    die();
}

if (isset($_POST['category'])) {
    $category = strtolower($_POST['category']);
} else {
    /* should never happen with the client -> no pretty error */
    http_response_code(400);
    echo "missing required parameter 'category'";
    die();
}
$valid_categories = ["time-trial", "online"];
if (!in_array($category, $valid_categories)) {
    /* should never happen with the client -> no pretty error */
    http_response_code(400);
    echo "invalid category. 'category' must be one of ['time-trial', 'online']";
    die();
}

if (isset($_POST["tags"])) {
    $tags = array_map("ltrim", explode(",",rtrim($_POST["tags"])));
} else {
    $tags = [];
}

try {
    $dao->createGuide($user_id, $track_id, $title, $category, $text, time(), $tags);
} catch (PDOException $e) {
    if ($pretty) {
        $_SESSION["databaseError"] = "Ein unerwarteter Fehler ist aufgetreten.";
        header("Location: ../user-page.php");
    } else {
        http_response_code(500);
        echo "could not create the guide for an unexpected reason";
    }
    die();
}

if ($pretty) {
    $_SESSION["guideCreatedMessage"] = "Guide erfolgreich erstellt";
    header("Location: ../guide-overview.php");
} else {
    echo "ok";
}
