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
    <link href="app.css" rel="stylesheet">
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
    <video autoplay> </video>
    <script>
        function hasGetUserMedia()
        {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
                return true;
            else
                return false;
        }
        if (hasGetUserMedia() == true)
        {
            alert("Got media");
            const constraints = {video: true};
            const video = document.querySelector("video");
            navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
                video.srcObject = stream;
            });
        }
    </script>
</body>
</html>