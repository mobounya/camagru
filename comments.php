<?php
	session_start();
	require_once("./config/setup.php");
    if (!isset($_SESSION['account']))
    {
        header("Location: index.php");
        return ;
    }
    echo $_POST["comment"];
?>