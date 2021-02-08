<?php
	session_start();
	require_once("./config/setup.php");
	require_once("./getPosts.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
	<title>Gallery</title>
</head>
<body>
    <div class="ft_navbar">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="app.php">App</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
		<?php
            $galleryPath = "gallery/";
			if (isset($_GET["page"]))
				$current_page = $_GET["page"];
			else
				$current_page = 0;
			$posts = getPosts(5 * $current_page, 5);
			foreach($posts as $post)
			{
				echo renderPost($post["gallery_id"], $post["username"], $galleryPath . $post["image"], $post["likes"]);
                echo "<div style=\"margin-top: 0px\"> </div>";
			}
		?>
</body>
</html>