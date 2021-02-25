<?php
session_start();
require_once("config/constants.php");
require_once(SCRIPTS_PATH . "/utils.php");
require_once(CONFIG_PATH . "/setup.php");

if (!isset($_SESSION["account"])) {
    $_SESSION["error"] = "Please log-in";
    header("Location: " . PUBLIC_ROOT . "login.php");
    return;
}
if (isset($_POST["gallery_id"])) {
    $postOwner = getPostOwner($pdo, $_POST["gallery_id"]);
    if ($postOwner["member_id"] === $_SESSION["member_id"]) {
        deletePost($pdo, $_POST["gallery_id"]);
        $_SESSION["success"] = "Post n#" . $_POST["gallery_id"] . " has been deleted successfully";
    } else
        $_SESSION["error"] = "You don't have permission to delete this post.";
    header("Location: " . PUBLIC_ROOT . "index.php");
    return;
}
if (!isset($_GET["gallery_id"])) {
    header("Location: " . PUBLIC_ROOT . "index.php");
    return;
}
$postOwner = getPostOwner($pdo, $_GET["gallery_id"]);
if ($postOwner["member_id"] !== $_SESSION["member_id"]) {
    $_SESSION["error"] = "You don't have permission to delete this post.";
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
    <title>Delete Post</title>
</head>

<body>
    <div style="margin-top: 40px; display: flex;" class="card">
        <div class="alert alert-danger" role="alert">
            You're about to delete post #<?= $_GET["gallery_id"] ?>
        </div>
        <div class="card-body">
            <p class="card-text">Would you like to delete this post?</p>
            <p style="color: #ff4136;" class="card-text">Note: This action is irreversible</p>
            <form method="POST">
                <input type="hidden" name="gallery_id" value="<?= $_GET['gallery_id'] ?>">
                <button class="btn btn-primary">Delete</button>
            </form>
        </div>
    </div>
</body>

</html>