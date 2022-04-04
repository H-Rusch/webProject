<?php
/*
 * Endpoint in the registration process.
 *
 * # Parameters
 * - 'pretty': GET/POST optional flag
 *     Without 'pretty' this acts like a rest api endpoint
 *     with useful feedback in plain text.
 *     For our website 'pretty' should be set.
 * - 'username': POST required string
 * - 'new-password': POST required string
 * - 'confirm-new-password': POST required string
 *      The given password again. Both passwords have to match 
 *      in order for the registration to work.
 * - 'email': POST required string
 */

include_once "../DAO/config.php";
include_once "./validation.php";

unset($_SESSION["registrationErrors"]);
unset($_SESSION["registrationInput"]);

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

if (isset($_POST["username"])) {
    if (validateUsername($_POST["username"])) {
        $username = $_POST["username"];
    } else {
        $errors[] = "Der Nutzername ist ungültig.";   
    }
} else {
    /* should never happen with the client -> no pretty error */
    http_response_code(400);
    echo "missing required parameter 'username'";
    die();
}

if (isset($_POST["new-password"])) {
    if (validatePassword($_POST["new-password"])) {
        $password1 = $_POST["new-password"];
    } else {
        $errors[] = "Das erste Passwort ist ungültig.";
    }
} else {
    /* should never happen with the client -> no pretty error */
    http_response_code(400);
    echo "missing required parameter 'new-password'";
    die();
}

if (isset($_POST["confirm-new-password"])) {
    if (validatePassword($_POST["confirm-new-password"])) {
        $password2 = $_POST["confirm-new-password"];
    } else {
        $errors[] = "Das zweite Passwort ist ungültig.";
    }
} else {
    /* should never happen with the client -> no pretty error */
    http_response_code(400);
    echo "missing required parameter 'confirm-new-password'";
    die();
}

if ($password1 == $password2) {
    $password = password_hash($password1, PASSWORD_DEFAULT);
} else {
    $errors[] = "Die Passwörter stimmen nicht überein.";
}

if (isset($_POST["email"])) {
    if (validateEMail($_POST["email"])) {
        $email = $_POST["email"];
    } else {
        $errors[] = "Die E-Mail Adresse ist ungültig.";   
    }
} else {
    /* should never happen with the client -> no pretty error */
    http_response_code(400);
    echo "missing required parameter 'email'";
    die();
}

$_SESSION["registrationInput"] = [$username, $email];

if (sizeof($errors) != 0) {
    if ($pretty) {
        $_SESSION["registrationErrors"] = $errors;
        header("Location: ../register.php");
    } else {
        http_response_code(422);
        print_r($errors);
    }
    die();
}

try {
    $key = random_str();
    $response_code = $dao->registerUser_start($key, $username, $password, $email);
    if ($response_code == 0) { // success
        unset($_SESSION["registrationInput"]);
        if ($pretty) {
            /*
             * Normally an e-mail would be sent here.
             */
            $_SESSION["registration_key"] = $key;
            header("Location: ../email-confirm.php?");
        } else {
            echo "sent email with more information<br/>DEBUG: " . $key;
        }
    } else if ($response_code == 1) { // username taken
        if ($pretty) {
            $_SESSION["registrationErrors"] = ["Der Nutzername ist bereits vergeben."];
            header("Location: ../register.php");
        } else {
            echo "username taken";
        }
    } else if ($response_code == 2) { // email taken
        unset($_SESSION["registrationInput"]);
        if ($pretty) {
            /*
             * Normally an e-mail would be sent here.
             */
            header("Location: ../email-taken.html");
        } else {
            echo "sent email with more information";
        }
    } else {
        echo "error";
    }
} catch (PDOException $e) {
    if ($pretty) {
        $_SESSION["databaseError"] = "Ein unerwarteter Fehler ist aufgetreten.";
        header("Location: ../register.php");
    } else {
        http_response_code(500);
        echo "could not register user for an unexpected reason";
    }
    die();
}

/**
 * Generate a random string, using a cryptographically secure
 * pseudorandom number generator (random_int)
 *
 * @param int    $length      How many characters do we want?
 * @param string $keyspace A string of all possible characters to select from
 * @return string
 */
 /* https://stackoverflow.com/questions/4356289/php-random-string-generator/31107425#31107425 */
function random_str(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}
