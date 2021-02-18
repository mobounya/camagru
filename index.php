<?php
session_start();
require_once("./config/setup.php");
require_once("./getPosts.php");
require_once("./utils.php");

if (isset($_SESSION['member_id']))
    $logged = "logout";
else
    $logged = "login";
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
    <div class="app-navbar">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="app.php">App</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $logged ?>.php"><?= $logged ?></a>
            </li>
        </ul>
    </div>
    <div style="margin-top: 40px; display: inline-block">
        <?php
        flashMessage();
        $galleryPath = "gallery/";
        if (isset($_GET["page"])) {
            if ($_GET["page"] <= 0)
                $current_page = 1;
            else
                $current_page = $_GET["page"];
        } else
            $current_page = 1;
        $posts = getPosts(5 * ($current_page - 1), 5);
        if ($posts == NULL) :
        ?>
            <h3 style="margin-left: 25px;">
                WOW !
                <small class="text-muted">such empty</small>
            </h3>
            <img src="assets/giphy.gif">
        <?php
        else :
            foreach ($posts as $post) {
                if (isset($_SESSION['member_id']) && ($post["member_id"] === $_SESSION['member_id']))
                    $delete = TRUE;
                else
                    $delete = FALSE;
                echo renderPost($post["gallery_id"], $post["username"], $galleryPath . $post["image"], $post["likes"], $delete);
            }
        endif;
        ?>
        <div id="pagination" style="display: flex; justify-content: center;">
            <nav style="margin-top: 20px;" aria-label="Page navigation example">
                <ul class="pagination">
                    <?php
                    $disabled = "";
                    $nPosts = countPosts();
                    $nPages = $nPosts / 5;
                    if (($nPosts % 5) > 0)
                        $nPages++;
                    $previous = ($current_page > 1) ? ($current_page - 1) : $current_page;
                    if ((int)$current_page === 1)
                        $disabled = "disabled";
                    echo "<li class=\"page-item $disabled\"><a class=\"page-link\" href=\"index.php?page=" . $previous . "\">Previous</a></li>";
                    for ($i = 1; $i <= $nPages; $i++) {
                        $active = "";
                        if ($i === (int)$current_page)
                            $active = "active";
                        echo "<li class=\"page-item $active\"><a class=\"page-link\" href=\"index.php?page=$i\">$i</a></li>";
                    }
                    $disabled = "";
                    if ((int)$current_page === (int)$nPages) {
                        $disabled = "disabled";
                        $next_page = $current_page;
                    } else
                        $next_page = $current_page + 1;
                    echo "<li class=\"page-item $disabled\"><a class=\"page-link\" href=\"index.php?page=$next_page\">Next</a></li>";
                    ?>
                </ul>
            </nav>
        </div>
    </div>
    <script type="text/javascript" src="js/like.js"></script>
</body>

</html>