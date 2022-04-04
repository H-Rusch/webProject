<?php
/*
 * Endpoint to delete a guide.
 *
 * # Parameters
 * - 'pretty': GET/POST optional flag
 *     Without 'pretty' this acts like a rest api endpoint
 *     with useful feedback in plain text.
 *     For the website 'pretty' should be set.
 * - 'guideID': GET/POST required integer
 *     The id of the guide to delete.
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
        echo "you must be logged in to delete a guide";
    }
    die();
}

try {
    $guide = $dao->getGuide($guide_id);
} catch (PDOException $e) {
    if ($pretty) {
        pretty_not_found();
    } else {
        http_response_code(500);
        echo "could not find the guide for an unexpected reason";
    }
    die();
}
if ($guide == null) {
    if ($pretty) {
        pretty_not_found();
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
    echo "you cannot delete a guide that is not yours";
    die();
}

try {
    $dao->deleteGuide($guide_id);
} catch (PDOException $e) {
    if ($pretty) {
        pretty_not_found();
    } else {
        http_response_code(500);
        echo "could not delete the guide for an unexpected reason";
    }
    die();
}
if ($pretty) {
    header("Location: ../user-page.php");
} else {
    echo "ok";
}

function pretty_not_found() {
    $_SESSION["databaseError"] = "Dieser Guide ist nicht mehr in der Datenbank verfügbar.";
    header("Location: ../user-page.php");
}

