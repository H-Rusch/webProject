<?php
include_once "../DAO/config.php";
session_unset();
session_destroy();

header("Location: ../home.php");

