<?php
session_start();
require_once("./utils.php");
require_once("./config/setup.php");
require_once("./getPosts.php");
if (!isset($_SESSION['account'])) {
    $_SESSION["error"] = "Please Log-in";
    header("Location: login.php");
    return;
}
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
        </ul>
    </div>

    <?php
    flashMessage();
    ?>

    <div id="camContainer" style="margin-left: 25px; margin-top: 50px">
        <div id="Disposable-imgs" display="display: inline-block;">
            <div class="row">
                <div class="col-sm">
                    <img data-role="sticker" data-name="chefhat" src="/assets/images/chefhat.png">
                </div>
                <div class="col-sm">
                    <img data-role="sticker" data-name="glasses" src="/assets/images/glasses.png">
                </div>
                <div class="col-sm">
                    <img data-role="sticker" data-name="grass" src="/assets/images/grass.png">
                </div>
            </div>
        </div>
        <div style="position: relative; display: inline-block" id="live-video">
            <video id="video" width="550px" autoplay></video> <br>
            <button id="btn_captures" disabled>Capture Photo</button>
        </div>
        <div id="output">
            <img id="photo" />
            <form action="/renderImg.php" method="POST" id="myForm">
                <input id="imgInput" type="hidden" name="img" />
                <input id="stickerInput" type="hidden" name="sticker" /> <br>
                <button type="submit">Save</button>
            </form>
        </div>
    </div>
    <div class="container">
        <!-- <div class="row">
            <div class="col-md-auto">
                <img src="gallery/photo_default_3980.jpeg">
            </div>
            <div class="col-md-auto">
                <img src="gallery/photo_default1_2415.jpeg">
            </div>
        </div>
        <div class="row">
            <div class="col-md-auto">
                <img src="gallery/photo_default_3980.jpeg">
            </div>
            <div class="col-md-auto">
                <img src="gallery/photo_default1_2415.jpeg">
            </div> -->
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
    <!-- gallery should be here -->
    </div>
    <canvas id="canvas" style="display: none"></canvas>
    <script type="text/javascript" src="/js/utils.js"></script>
    <script type="text/javascript" src="/js/initCamera.js"></script>
    <script type="text/javascript" src="/js/handleStickers.js"></script>
</body>

</html>