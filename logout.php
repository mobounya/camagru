<?php
session_start();
if (!isset($_SESSION["account"])) {
    $_SESSION["error"] = "Already logged out";
    header("location: index.php");
    return;
}
session_destroy();
session_start();
$_SESSION["success"] = "Logged out successfully";
header("Location: index.php");
return;
