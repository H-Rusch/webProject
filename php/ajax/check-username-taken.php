<?php
include_once "../DAO/config.php";

$name = $_GET["name"];

$hint = "";
if ($name != null && $name != "") {
    $taken = $dao->isUsernameTaken($_GET["name"]);

    if ($taken) {
        $hint = "Der Nutzername ist schon vergeben.";
    }
}

echo $hint;
?>
