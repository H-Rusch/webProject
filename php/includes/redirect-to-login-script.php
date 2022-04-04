<?php

// redirect user to the login page if he is not already logged in
if (!isset($_SESSION["userID"])) {
    // save the requested page, so the user can be sent to that page after he logged in
    $_SESSION["requestedSite"] = $_SERVER["PHP_SELF"]; 
    header("Location: ./login.php");
} 

