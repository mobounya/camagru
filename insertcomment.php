<?php
session_start();
require_once("./config/setup.php");
require_once("./getPosts.php");
function    InsertComment($pdo, $gallery_id, $member_id, $comment)
{
    $sql_query = "INSERT INTO `comments` (gallery_id, member_id, comment) VALUES (:gr_id, :mb_id, :cmnt)";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":gr_id" => $gallery_id,
        ":mb_id" => $member_id,
        ":cmnt" => $comment
    ));
    $stmt->closeCursor();
}

function    commentAlert($opEmail, $author, $gallery_id)
{
    $subject = "New comment!";
    $message = "$author has commented on your post:\nhttps://{$_SERVER["SERVER_NAME"]}/comments.php?gallery_id=$gallery_id";
    mail($opEmail, $subject, $message);
}


if (!isset($_SESSION["account"])) {
    header("Location: index.php");
    return;
}
if (isset($_POST["gallery_id"]) && isset($_POST["comment"])) {
    $postData = getPostById($_POST["gallery_id"]);
    if ($postData == NULL)
        die("no such gallery");
    $opData = getUserData($postData["member_id"]);
    InsertComment($pdo, $_POST["gallery_id"], $_SESSION["member_id"], $_POST["comment"]);
    $authorUsername = $_SESSION["username"];


    $opEmail = $postData["email"];
    $notifications = $opData["notification"];

    if ($notifications == true)
        commentAlert($opEmail, $authorUsername, $_POST["gallery_id"]);
    header("Location: comments.php?gallery_id=" . $_POST["gallery_id"]);
} else {
    header("Location: index.php");
    return;
}
