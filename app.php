<?php
    session_start();
    if (!isset($_SESSION['account']))
    {
        header("Location: index.php");
        return ;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="styling/app.css" rel="stylesheet">
    <title>HOME</title>
</head>
<body>
    <div class="ft_navbar">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="app.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Gallery</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>

    <?php
        if (isset($_SESSION["verification"]))
        {
            echo "<p style=\"color: green\">";
            echo $_SESSION["verification"];
            echo "</p>";
            unset($_SESSION["verification"]);
        }
    ?>

    <div id="camContainer" style="margin-left: 25px; margin-top: 50px">
        <div id="Disposable-imgs" style="border-style: dotted; height: 150px; width: 51%;">
            <img data-role="sticker" data-name="chefhat" src="smallchefhat.png">
        </div>
        <div style="position: relative; display: inline-block" id="live-video">
            <video id="video" autoplay></video> <br>
            <button id="btn_captures">Capture Photo</button>
        </div>
        <div id="output">
            <img id="photo" alt="The screen capture will appear in this box.">
        </div>
    </div>
    <canvas id="canvas" style="display: none"></canvas>
    <script type="text/javascript" src="/js/utils.js"></script>
    <script type="text/javascript" src="/js/initCamera.js"></script>
    <script type="text/javascript" src="/js/handleStickers.js"></script>
</body>
</html>