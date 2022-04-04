<?php
include_once "../DAO/config.php";

/*
 * Script for the AJAX call to like/ dislike a guide.
 * Will like/ dislike a guide and send the amount of likes/ dislikes the guide has as a json object.
 */ 

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

if (isset($_POST["userID"]) && isset($_SESSION["userID"]) && $_POST["userID"] == $_SESSION["userID"]) {
    $userID = $_POST["userID"];
} else {
    http_response_code(401);
    echo "Du musst eingeloggt sein, um einen Guide zu liken oder disliken.";
    die();
}

if (isset($_POST["guideID"])) {
    $guideID = $_POST["guideID"];
} else {
    http_response_code(400);
    echo "Die Anfrage ist nicht vollständig.";
    die();
}

if (isset($_POST["like"])) {
    try {
        $likeDislikeCount = $dao->likeGuide($userID, $guideID);
        $guide = $dao->getGuide($guideID);
        $likeDislikeCount = ["likes" => $guide->getLikes(), "dislikes" => $guide->getDislikes()];
        http_response_code(200);
        echo json_encode($likeDislikeCount);
        exit();
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Der Guide konnte aus einem unbekannten Grund nicht geliked werden.";
        die();
    }
}

if (isset($_POST["dislike"])) {
    try {
        $likeDislikeCount = $dao->dislikeGuide($userID, $guideID);
        $guide = $dao->getGuide($guideID);
        $likeDislikeCount = ["likes" => $guide->getLikes(), "dislikes" => $guide->getDislikes()];
        http_response_code(200);
        echo json_encode($likeDislikeCount);
        exit();
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Der Guide konnte aus einem unbekannten Grund nicht gedisliked werden.";
        die();
    }
}


