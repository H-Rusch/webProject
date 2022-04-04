<?php
include_once "../DAO/config.php";

$guides = [];

if (isset($_REQUEST["search"]) && $_REQUEST["search"] != "") {
    if (isset($_REQUEST["userID"])) {
        $guides = $dao->searchGuide($_REQUEST["search"], $_REQUEST["userID"]);
    } else {
        if (isset($_REQUEST["offset"])) {
            $guides = $dao->searchGuide($_REQUEST["search"], null, $_REQUEST["offset"]);
        } 
    }
} else {
    if (isset($_REQUEST["userID"])) {
        $guides = $dao->getGuidesForUser($_REQUEST["userID"]);
    } else {
        if (isset($_REQUEST["offset"]) && isset($_REQUEST["filter"])) {
            $guideIDs = json_decode($_REQUEST["guides"], true);
            $guides = $dao->sortGuidesBy($guideIDs, $_REQUEST["filter"]);
        } elseif (isset($_REQUEST["offset"])){
            $guides = $dao->getGuides($_REQUEST["offset"]);
        } else {
            $guides = $dao->getGuides();
        }
    }
}

$json = json_encode($guides);

echo $json;

?>
