<?php
require_once(__DIR__ . "/../config/constants.php");
require_once(CONFIG_PATH . "/setup.php");
require_once(SCRIPTS_PATH . "/utils.php");

function    getPosts($offset, $nposts)
{
    global $pdo;

    $sql_query = "SELECT username, gallery.* FROM gallery INNER JOIN members ON gallery.member_id=members.member_id ORDER BY gallery_id DESC LIMIT :offset, :nposts";
    $stmt = $pdo->prepare($sql_query);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':nposts', $nposts, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if (empty($data))
        $data = NULL;
    return $data;
}

// Get post data from table by gallery_id
function    getPostById($gallery_id)
{
    global $pdo;

    $sql_query = "SELECT username, email, gallery.* FROM gallery INNER JOIN members 
			ON gallery.member_id=members.member_id WHERE gallery_id = :id";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(":id" => $gallery_id));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if (empty($data))
        $data = NULL;
    return $data;
}

// Render a single post card
function    renderPost($gallery_id, $username, $img, $likes, $delete)
{
    global $pdo;

    if ($delete == TRUE)
        $delete_icon = "<div><a href=\"deletePost.php?gallery_id=$gallery_id\"><i class=\"align-self-end bi bi-trash-fill\"></i></a></div>";
    else
        $delete_icon = "";
    $class = "bi bi-suit-heart";
    $function = "like($gallery_id)";
    if (isset($_SESSION["member_id"])) {
        if (isLiked($pdo,  $_SESSION["member_id"], $gallery_id)) {
            $class = "bi bi-heart-fill";
            $function = "unlike($gallery_id)";
        }
    } else {
        $class = "";
        $function = "";
    }
    $container = "<div class=\"shadow-sm p-3 mb-5 bg-white rounded\">";
    $card_header = "<div style=\"display: flex; justify-content: space-between\" class=\"card-header\">";
    $user = "<div><i class=\"bi bi-caret-right-fill\">$username</i></div>";
    $img = "<img class=\"img-fluid\" src=\"" . htmlspecialchars($img) . "\"><br>";
    $icon = "";
    if (isset($_SESSION["account"]))
        $icon = "<i style=\"margin-left: 5px;\" id=\"like_$gallery_id\" class=\"$class\" onclick=\"$function\">" . htmlspecialchars($likes) . "</i><br>";
    $comment_link = "<a href=\"comments.php?gallery_id=" . htmlspecialchars($gallery_id) . "\">Comments</a>";
    return $container . "\n" . $card_header . "\n" . $user . "\n" . $delete_icon . "</div>\n" . $img . "\n" . $icon . "\n" . $comment_link . "</div>";
}

// Get post comments
function    getComments($gallery_id)
{
    global $pdo;

    $sql_query = "SELECT username, comments.* FROM `comments` INNER JOIN 
						members ON comments.member_id=members.member_id WHERE gallery_id = :id";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(":id" => $gallery_id));
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if (empty($data))
        return NULL;
    return $data;
}

// render a single comment card
function    renderComment($comment, $username)
{
    return "<div style=\"margin-top: 40px\" class=\"card\">
        <i class=\"bi bi-caret-right-fill\">" . htmlspecialchars($username) . "</i>
        <div class=\"card-body\">" . htmlspecialchars($comment) .
        "</div></div>";
}

// return all posts in gallery table
function    countPosts()
{
    global $pdo;

    $sql_query = "SELECT count(*) FROM `gallery`";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_NUM);
    $stmt->closeCursor();
    return $data[0][0];
}

// Get user data by member id
function    getUserData($member_id)
{
    global $pdo;

    $sql_query = "SELECT * FROM `members` WHERE member_id=:id";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":id" => $member_id
    ));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if (empty($data))
        return NULL;
    return $data;
}

// Get user data by email
function    getUserByEmail($email)
{
    global $pdo;

    $sql_query = "SELECT * FROM members WHERE email=:email";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":email" => $email
    ));
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $data;
}

// Get member (member_id) posts
function    getUserPosts($pdo, $member_id)
{
    $sql_query = "SELECT * FROM gallery WHERE member_id=:mb_id";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":mb_id" => $member_id
    ));
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $data;
}
