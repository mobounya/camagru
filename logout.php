<?php
session_start();
require_once("config/constants.php");
if (!isset($_SESSION["account"])) {
    $_SESSION["error"] = "Already logged out";
    header("Location: " . PUBLIC_ROOT . "index.php");
    return;
}
session_destroy();
session_start();
$_SESSION["success"] = "Logged out successfully";
header("Location: " . PUBLIC_ROOT . "index.php");
return;
