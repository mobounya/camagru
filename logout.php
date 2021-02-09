<?php
    session_start();
    if (!isset($_SESSION["account"]))
    {
        header("location: index.php");
        return ;
    }
    session_destroy();
    session_start();
    $_SESSION["loggedout"] = "Logged out successfully";
    header("Location: index.php");
    return ;
?>