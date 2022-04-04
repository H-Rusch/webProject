<?php
/*
 * Endpoint to edit a guide.
 *
 * # Parameters
 * - 'pretty': GET/POST optional flag
 *     Without 'pretty' this acts like a rest api endpoint
 *     with useful feedback in plain text.
 *     For the website 'pretty' should be set.
 * - 'guideID': GET/POST required string
 * - 'title': POST optional string
 * - 'text': POST optional string
 *     The content of the guide in Markdown syntax.
 * - 'track': POST optional string
 *     The tracks name, for example 'Rainbow Road'.
 * - 'category': POST optional string
 *     One of ["time-trial", "online"]
 * - 'tags': POST optional comma-separated list of strings
 *     Tags are invisible. They enhance search results.
* - 'token' : GET/POST required string
 *      A token to prevent CSRF attacks.
 */

include_once "../DAO/config.php";

$pretty = isset($_REQUEST["pretty"]);

if (isset($_REQUEST["token"])) {
    if (!(isset($_SESSION["token"]) && $_SESSION["token"] == $_REQUEST["token"])) {
        http_response_code(403);
        echo "security token does not match";
        die();
    }
} else {
    http_response_code(400);
    echo "missing required parameter 'token'";
    die();
}

if (isset($_REQUEST["guideID"])) {
    $guide_id = $_REQUEST["guideID"];
} else {
    /* should never happen with the client -> no pretty error */
    http_response_code(400);
    echo "missing required parameter 'guideID'";
    die();
}

if (isset($_SESSION["userID"])) {
    $user_id = $_SESSION["userID"];
} else {
    if ($pretty) {
        header("Location: ../login.php");
    } else {
        http_response_code(401);
        echo "you must be logged in to edit a guide";
    }
    die();
}

try {
    $guide = $dao->getGuide($guide_id);
} catch (PDOException $e) {
    if ($pretty) {
        $_SESSION["databaseError"] = "Ein unerwarteter Fehler ist aufgetreten. a";
        header("Location: ../user-page.php");
    } else {
       /* should never happen with the client -> no pretty error */
       http_response_code(400);
       echo "invalid difficulty. 'difficulty' must be one of [1, 2, 3, 4, 5]";
       die();
    }
    die();
}
if ($guide == null) {
    if ($pretty) {
        $_SESSION["databaseError"] = "Dieser Guide ist nicht mehr in der Datenbank verfügbar.";
        header("Location: ../user-page.php");
    } else {
        http_response_code(404);
        echo "the requested guide does not exist";
    }
    die();
}

$author_id = $guide->getAuthor();
if ($author_id != $user_id) {
    /* should never happen with the client -> no pretty error */
    http_response_code(403);
    echo "you cannot edit a guide that is not yours";
    die();
}

if (isset($_POST['title'])) {
    $title = htmlentities($_POST['title']);
} else {
    $title = $guide->getTitle();
}

if (isset($_POST['text'])) {
    $text = $_POST['text'];
} else {
    $text = $guide->getText();
}

if (isset($_POST['track'])) {
    $track_name = $_POST['track'];
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
            $_SESSION["databaseError"] = "Ein unerwarteter Fehler ist aufgetreten. b";
            header("Location: ../user-page.php");
        } else {
            http_response_code(500);
            echo "could not create the guide for an unexpected reason";
        }
        die();
    }
} else {
    $track_id = $guide->getTrack();
}


if (isset($_POST['category'])) {
    $category = strtolower($_POST['category']);
    $valid_categories = ["time-trial", "online"];
    if (!in_array($category, $valid_categories)) {
        /* should never happen with the client -> no pretty error */
        http_response_code(400);
        echo "invalid category. 'category' must be one of ['time-trial, 'onlne']";
        die();
    }
} else {
    $category = $guide->getCategory();
}

if (isset($_POST["tags"])) {
    $tags = array_map("ltrim", explode(",",rtrim($_POST["tags"])));
} else {
    $tags = $guide->getTags();
}

try {
    $dao->updateGuide($guide_id, $track_id, $title, $category, $text, time(), $tags);
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
    header("Location: ../guide-overview.php");
} else {
    echo "ok";
}

