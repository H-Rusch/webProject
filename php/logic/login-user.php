<?php
/*
 * Endpoint for logging in a user.
 *
 * # Parameters
 * - 'pretty': GET/POST optional flag
 *     Without 'pretty' this acts like a rest api endpoint
 *     with useful feedback in plain text.
 *     For our website 'pretty' should be set.
 * - 'username': POST required string
 * - 'password': POST required string
 */

include_once "../DAO/config.php";
include_once "./validation.php";

unset($_SESSION["loginErrors"]);
unset($_SESSION["loginInput"]);

$pretty = isset($_REQUEST["pretty"]);
$errors = [];

if (isset($_SESSION["userID"])) {
    if ($pretty) {
        header("Location: ../user-page.php");
    } else {
        http_response_code(403);
        echo "you are already logged in";
    }
    die();
}

if (isset($_POST['username'])) {
    if (validateUsername($_POST["username"])) {
        $username = $_POST["username"];
        $_SESSION["loginInput"] = $username;
    } else {
        $errors[] = "Der Nutzername ist ungültig.";   
    }
} else {
    /* should never happen with our client -> no pretty error */
    http_response_code(400);
    echo "missing required parameter 'username'";
    die();
}

if (isset($_POST["password"])) {
    if (validatePassword($_POST["password"])) {
        $password = $_POST["password"];
    } else {
        $errors[] = "Das Passwort ist ungültig.";
    }
} else {
    /* should never happen with our client -> no pretty error */
    http_response_code(400);
    echo "missing required parameter 'password'";
    die();
}

if (sizeof($errors) != 0) {
    if ($pretty) {
        $_SESSION["loginErrors"] = $errors;
        header("Location: ../login.php");
    } else {
        http_response_code(422);
        print_r($errors);
    }
    die();
}

try {
    $errors = $dao->login($username, $password);
} catch (PDOException $e) {
    if ($pretty) {
        $_SESSION["databaseError"] = "Ein unerwarteter Fehler ist aufgetreten.";
        header("Location: ../login.php");
    } else {
        http_response_code(500);
        echo "could not login user for an unexpected reason";
    }
    die();
}

if (sizeof($errors) == 0) {
    unset($_SESSION["loginInput"]);
    if ($pretty) {
        if (isset($_SESSION["requestedSite"])) {
            $location = $_SESSION["requestedSite"];
            header("Location: $location");
        } else {
            header("Location: ../home.php");
        }
    } else {
        echo "ok";
    }
} else {
    if ($pretty) {
        $_SESSION["loginErrors"] = $errors;
        header("Location: ../login.php");        
    } else {
        http_response_code(422);
        print_r($errors);
    }
}

