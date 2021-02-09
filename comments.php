<?php
	session_start();
    require_once("./config/setup.php");
    require_once("getPosts.php");
    if (!isset($_GET["gallery_id"]))
        Header("Location: index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
	<title>Comments</title>
</head>
<body>
    <div id="comment_section">
        <?php
            $gallery_path = "gallery/";
            $post = getPostById($_GET["gallery_id"]);
            echo renderPost($post["gallery_id"], $post["username"], $gallery_path . $post["image"], $post["likes"]);
            $comments = getComments($_GET["gallery_id"]);
            if ($comments === NULL)
            {
                echo "<div style=\"margin-top: 30px\" class=\"alert alert-primary\" role=\"alert\">
                    No comments on this post !
                </div>";
            }
            else
            {
                foreach($comments as $comment)
                {
                    echo renderComment($comment['comment'], $comment['username']);
                }
            }
        ?>
        <?php
            if (isset($_SESSION['member_id']))
            {
                echo "<div style=\"margin-top: 30px\" id=\"addComment\">";
                echo "<form action=\"insertcomment.php\" method=\"POST\">";
                echo "<input type=\"hidden\" name=\"gallery_id\" value=\"{$post['gallery_id']}\">";
                echo "<input type=\"hidden\" name=\"member_id\" value=\"{$_SESSION['member_id']}?>\">";
                echo "<label for=\"comment\">Added a comment</label> <br>";
                echo "<textarea id=\"comment\" name=\"comment\" rows=\"2\" cols=\"50\"> </textarea> <br>";
                echo "<button>Post Comment</button>";
                echo "</form>";
                echo "</div>";
            }
            else
            {
                echo "<div class=\"alert alert-dark\" role=\"alert\">
                    Please <a href=\"login.php\"> Log-in </a> to post a comment
                </div>";
            }
        ?>
    </div>
</body>
</html>