<?php
    session_start();
    $img = imagecreatefromjpeg($_GET["photo"]);
    var_dump($img);
?>