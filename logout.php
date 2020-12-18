<?php
    if (isset($_SESSION["account"]))
    {
        session_start();
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