<?php

/*
 * # Parameters
 * - 'key': GET/POST required string
 */

include_once "../DAO/config.php";

if (isset($_REQUEST["key"])) {
    $key = $_REQUEST["key"];
    try {
        $response_code = $dao->registerUser_complete($key);
    } catch (PDOException $e) {
        var_dump($e);
        $_SESSION["databaseError"] = "Ein unerwarteter Fehler ist aufgetreten.";
        header("Location: ../register.php");
        die();
    }
    if ($response_code == 0) {
        /* This text will never be shown,
         * unless the user configured their browser to ignore redirects
         */
        echo "Du bist nun registriert. Als nächstes kannst du dich anmelden";
        unset($_SESSION["loginInput"]);
        header("Location: ../login.php");
    } else if ($response_code == 1) {
        /* This case can happen,
         * if a key that does not exists is guessed,
         * or a email was used for registration multiple times
         * and the registration is also confirmed multiple times.
         */
        echo "ungültiger/abgelaufener link";
        http_response_code(404);
    } else if ($response_code == 2) {
        /* This case probably cannot happen currently.
         * But if the database was modified manually,
         * or changes to the registration process are made,
         * this case could become possible.
         */
        echo "Nutzername bereits vergeben";
        http_response_code(409);
    } else if ($response_code == 3) {
        /* This does not leak registered emails,
         * because the message can only be shown,
         * if the unique and private key
         * associated with that email address was used.
         * Guessing that key is practically impossible.
         */
        echo "Du bist schon mit dieser email registriert";
        http_response_code(409);
    } else {
        $_SESSION["databaseError"] = "Etwas ist shief gelaufen.";
        header("Location: ../register.php");
    }
} else {
    /* should never happen -> no pretty error */
    http_response_code(400);
    echo "missing required parameter 'key'";
    die();
}
?>