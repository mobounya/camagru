<?php
session_start();
require_once("config/constants.php");
require_once(CONFIG_PATH . "/setup.php");
require_once(SCRIPTS_PATH . "/getPosts.php");


require_once(SCRIPTS_PATH . "/insertcomment.php");

if (!isset($_GET["gallery_id"])) {
    header("Location: " . PUBLIC_ROOT . "index.php");
    return;
}
if (isset($_SESSION['member_id'])) {
    $pageName = "logout";
    $path = "/logout.php";
} else {
    $pageName = "login";
    $path = "./login.php";
}
$post = getPostById($_GET["gallery_id"]);
if ($post == NULL) {
    $_SESSION["error"] = "Post dosen't exist";
    header("Location: " . PUBLIC_ROOT . "index.php");
    return;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="styling/app.css" rel="stylesheet">
    <title>Comments</title>
</head>

<body>
    <main class="container pt-2">
        <div class="app-posts">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="app.php">App</a>
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
                <li class="nav-item">
                    <a class="nav-link" href="<?= $path ?>"><?= $pageName ?></a>
                </li>
            </ul>
        </div>
        <?php
        $gallery_path = "gallery/";
        if (isset($_SESSION['member_id']) && ($post["member_id"] === $_SESSION['member_id']))
            $delete = TRUE;
        else
            $delete = FALSE;
        echo renderPost($post["gallery_id"], $post["username"], $gallery_path . $post["image"], $post["likes"], $delete);
        $comments = getComments($_GET["gallery_id"]);
        if ($comments === NULL) :
        ?>
            <div style="margin-top: 30px" class="alert alert-primary" role="alert">
                No comments on this post !
            </div>
        <?php
        else : {
                foreach ($comments as $comment) {
                    echo renderComment($comment['comment'], $comment['username']);
                }
            }
        endif;
        ?>
        <?php
        if (isset($_SESSION['member_id'])) :
        ?>
            <div style="margin-top: 30px" id="addComment">
                <form method="POST">
                    <input type="hidden" name="gallery_id" value="<?= $post['gallery_id'] ?>">
                    <label for="comment">Added a comment</label> <br>
                    <textarea id="comment" name="comment" rows="2" cols="50"> </textarea> <br>
                    <button class="btn btn-primary my-2">Post Comment</button>
                </form>
            </div>
        <?php
        else :
        ?>
            <div style="margin-top: 10px" class="alert alert-dark" role="alert">
                Please <a href="login.php">Log-in</a> to post a comment
            </div>
        <?php
        endif;
        ?>
        <script type="text/javascript" src="js/like.js"></script>
    </main>
    <?php
    require_once("footer.php");
    ?>
</body>

</html>