<?php
    session_start();
    if (isset($_SESSION["account"]))
    {
        session_destroy();
        header("Location: index.php");
        return ;
    }
    else
    {
        header("Location: index.php");
        return ;
    }
?>