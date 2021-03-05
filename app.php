<?php
session_start();
require_once("config/constants.php");
require_once(SCRIPTS_PATH . "/utils.php");
require_once(CONFIG_PATH . "/setup.php");
require_once(SCRIPTS_PATH . "/getPosts.php");

if (!isset($_SESSION['account'])) {
    $_SESSION["error"] = "Please Log-in";
    header("Location: " . PUBLIC_ROOT . "login.php");
    return;
}

require_once(SCRIPTS_PATH . "/renderImg.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="styling/app.css" rel="stylesheet">
    <title>HOME</title>
</head>

<body>
    <div class="ft_navbar">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="app.php">App</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
            <?php
            if (isset($_SESSION["account"])) :
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
            <?php
            endif;
            ?>
        </ul>
    </div>

    <?php
    flashMessage();
    ?>

    <div id="camContainer" style="margin-top: 50px;" class="px-4">
        <div id="Disposable-imgs" class="stickers">
            <img data-role="sticker" data-name="chefhat" src="/assets/images/chefhat.png">
            <img data-role="sticker" data-name="glasses" src="/assets/images/glasses.png">
            <img data-role="sticker" data-name="grass" src="/assets/images/grass.png">
        </div>
        <div style="position: relative; display: flex; flex-direction: column; align-items: center; flex-wrap: wrap;">
            <div style="position: relative; display: inline-block" id="live-video">
                <video id="video" width="640px" style="object-fit: contain; width: 100%; max-width: 640px" autoplay></video>
            </div>
            <button id="btn_captures" disabled class="btn btn-primary my-2">Capture Photo</button>
        </div>

        <div id="output" style="display: flex; justify-content: center">
            <img id="photo" style="max-width: 100%; max-height: 480px;" />
        </div>
        <form method="POST" id="myForm">
            <input id="imgInput" type="hidden" name="img" />
            <input id="stickerInput" type="hidden" name="sticker" /> <br>
            <button type="submit" class="btn btn-primary my-2">Save</button>
        </form>
    </div>
    <?php
    $i = 0;
    $userPosts = getUserPosts($pdo, $_SESSION["member_id"]);
    echo "<div class=\"row\">";
    foreach ($userPosts as $post) {
        if ($i !== 0 && $i % 2 == 0) {
            echo "</div>";
            echo "<div class=\"row\">";
        }
        echo "<div class=\"col-md-6\">";
        echo "<img src=\"gallery/{$post["image"]}\">";
        echo "</div>";
        $i++;
    }
    ?>
    </div>
    <canvas id="canvas" style="display: none"></canvas>
    <script type="text/javascript" src="/js/utils.js"></script>
    <script type="text/javascript" src="/js/initCamera.js"></script>
    <script type="text/javascript" src="/js/handleStickers.js"></script>
</body>

</html>