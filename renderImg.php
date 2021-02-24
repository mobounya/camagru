<?php
session_start();
require_once("./config/setup.php");
if (!isset($_SESSION["account"])) {
    header("Location: index.php");
    return;
}
// Verify if sticker img exist, return its path if it does.
function    verifySticker($sticker)
{
    $available_stickers = array(
        "chefhat" => "./assets/images/chefhat.png",
        "glasses" => "./assets/images/glasses.png",
        "grass" => "./assets/images/grass.png"
    );
    foreach ($available_stickers as $av_sticker => $path) {
        if ($av_sticker === $sticker)
            return ($path);
    }
    return (FALSE);
}
// Output finale edited img as jpeg file in gallery path.
function    generateImgFile($username, $img)
{
    $gallery_path = "gallery/";

    $photoName = "photo_" . $username . "_" . rand(10, 10000) . ".jpeg";
    $photoPath = $gallery_path . $photoName;
    imagejpeg($img, $photoPath);
    return ($photoName);
}
// Insert Final image into gallery table.
function    InsertGallery($member_id, $photoName)
{
    global $pdo;

    $query = "INSERT INTO gallery (member_id, image) VALUES (:mb_id, :img)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array(':mb_id' => $member_id, ':img' => $photoName));
}
if (($stickerPath = verifySticker($_POST['sticker'])) === FALSE)
    die("Invalid Sticker");

$stickerSize = getimagesize($stickerPath);

// Create jpeg img resource for user_photo.
$img = imagecreatefromjpeg($_POST["img"]);

$imagewidth = imagesx($img);
$imageHeight = imagesy($img);

if ($stickerSize[0] > $imagewidth || $stickerSize[1] > $imageHeight)
    die("Invalid image size");

// Create png img resource for sticker.
$sticker = imagecreatefrompng($stickerPath);

// Get Sticker size.

// Place sticker in img.
imagecopy($img, $sticker, ($imagewidth - $stickerSize[0]) / 2, ($imageHeight - $stickerSize[1]) / 2, 0, 0, $stickerSize[0], $stickerSize[1]);

$photoName = generateImgFile($_SESSION['username'], $img);
InsertGallery($_SESSION["member_id"], $photoName);
header("Location: index.php");
