<?php
    require_once("./config/setup.php");
    if (!isset($_SESSION["account"]))
    {
        header("Location: index.php");
        return ;
    }
    if (isset($_POST["gallery_id"]) && isset($_POST["member_id"]) && isset($_POST["comment"]))
    {
        $sql_query = "INSERT INTO `comments` (gallery_id, member_id, comment) VALUES (:gr_id, :mb_id, :cmnt)";
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(array(
            ":gr_id" => $_POST["gallery_id"],
            ":mb_id" => $_POST["member_id"],
            ":cmnt" => $_POST["comment"]
        ));
        $stmt->closeCursor();
        header("Location: comments.php?gallery_id=" . $_POST["gallery_id"]);
    }
    else
    {
        header("Location: index.php");
        return ;
    }
?>