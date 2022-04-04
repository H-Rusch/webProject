<?php
/*
 * Endpoint to like or dislike a guide.
 *
 * # Parameters
 * - 'pretty': GET/POST optional flag
 *     Without 'pretty' this acts like a rest api endpoint
 *     with useful feedback in plain text.
 *     For our website 'pretty' should be set.
 * - 'guideID': GET/POST required integer
 *     The id of the guide to delete.
 * - 'like': GET/POST optional flag
 *      Flag which indicates the guide should be liked.
 * - 'dislike': GET/POST optional flag
 *      Flag which indicates the guide should be disliked.
 * - 'token' : GET/POST required string
 *      A token to prevent CSRF attacks.
 */

include_once "../DAO/config.php";

$pretty = isset($_REQUEST["pretty"]);

if (isset($_REQUEST["token"])) {
    if (!(isset($_SESSION["token"]) && $_SESSION["token"] == $_REQUEST["token"])) {
        http_response_code(403);
        echo "token does not match or is not set";
        die();
    }
} else {
    http_response_code(400);
    echo "missing required parameter 'token'";
    die();
}

if (isset($_REQUEST["guideID"])) {
    $guideID = $_REQUEST["guideID"];
} else {
    http_response_code(400);
    echo "missing required parameter 'guideID'";
    die();
}

if (isset($_SESSION["userID"])) {
    $userID = $_SESSION["userID"];
} else {
    if ($pretty) {
        // if a user is not logged in, redirect the user to the login site
        $_SESSION["requestedSite"] = "../guide.php?id=$guideID";
        header("Location: ../login.php");
    } else {
        http_response_code(401);
        echo "you must be logged in to rate a guide";
    }
    die();
}

if (isset($_REQUEST["like"])) {
    try {
        $dao->likeGuide($userID, $guideID);
        echo "guide liked";
    } catch (PDOException $e) {
        if ($pretty) {
            $_SESSION["databaseError"] = "Ein unerwarteter Serverfehler ist aufgetreten.";
            header("Location: ../guide-overview.php");
        } else {
            http_response_code(500);
            echo "could not like the guide for an unexpected reason";
        }
        die();
    }
}

if(isset($_REQUEST["dislike"])) {
    try {
        $dao->dislikeGuide($userID, $guideID);
        echo "guide disliked";
    } catch (PDOException $e) {
        if ($pretty) {
            $_SESSION["databaseError"] = "Ein unerwarteter Serverfehler ist aufgetreten.";
            header("Location: ../guide-overview.php");
        } else {
            http_response_code(500);
            echo "could not dislike the guide for an unexpected reason";
        }
        die();
    }
}

if ($pretty) {
    header("Location: ../guide.php?id=$guideID");
} else {
    echo "ok";
}


