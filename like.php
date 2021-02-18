<?php
session_start();
require_once("config/setup.php");
require_once("utils.php");

function    likePost($pdo, $gallery_id, $member_id)
{
    $sql_query = "
            START TRANSACTION;
            INSERT INTO likes(gallery_id, member_id) VALUES(:g_id, :m_id);
            UPDATE gallery SET likes=likes+1 WHERE gallery_id=:g_id;
            COMMIT;";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":g_id" => $gallery_id,
        ":m_id" => $member_id
    ));
}

function    unlikePost($pdo, $gallery_id, $member_id)
{
    $sql_query = "
        START TRANSACTION;
        DELETE FROM likes WHERE gallery_id=:g_id AND member_id=:m_id;
        UPDATE gallery SET likes=likes-1 WHERE gallery_id=:g_id;
        COMMIT;";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":g_id" => $gallery_id,
        ":m_id" => $member_id
    ));
}

if (!isset($_SESSION["member_id"])) {
    die("Si flan");
}

if (isset($_POST["gallery_id"]) && isset($_POST["action"])) {
    if ($_POST["action"] === "like") {
        if (isLiked($pdo, $_SESSION["member_id"], $_POST["gallery_id"]))
            return;
        likePost($pdo, $_POST["gallery_id"], $_SESSION["member_id"]);
        $likes = getLikes($pdo, $_POST["gallery_id"]);
        echo $likes;
    } else if ($_POST["action"] === "unlike") {
        if (isLiked($pdo, $_SESSION["member_id"], $_POST["gallery_id"]) == false)
            return;
        unlikePost($pdo, $_POST["gallery_id"], $_SESSION["member_id"]);
        $likes = getLikes($pdo, $_POST["gallery_id"]);
        echo $likes;
    }
}
