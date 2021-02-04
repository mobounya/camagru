<?php
    session_start();
    $img = imagecreatefromjpeg($_POST["img"]);
    $stickerPath = "./assets/images/" . $_POST["sticker"] . ".png";
    $sticker = imagecreatefrompng($stickerPath);
    $size = getimagesize($stickerPath);
    imagecopy($img, $sticker, 280, 50, 0, 0, $size[0], $size[1]);
    imagejpeg($img, "./photo.jpeg");
?>