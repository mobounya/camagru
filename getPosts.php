<?php
	require_once("./config/setup.php");
    function    getPosts($offset, $nposts)
    {
        global $pdo;

        $sql_query = "SELECT username, gallery.* FROM gallery INNER JOIN members ON gallery.member_id=members.member_id LIMIT :offset, :nposts";
        $stmt = $pdo->prepare($sql_query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':nposts', $nposts, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

	function	getPostById($gallery_id)
	{
		global $pdo;

		$sql_query = "SELECT username, gallery.* FROM gallery INNER JOIN members 
			ON gallery.member_id=members.member_id WHERE gallery_id = :id";
		$stmt = $pdo->prepare($sql_query);
		$stmt->execute(array(":id" => $gallery_id));
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $data;
	}
    function    renderPost($gallery_id, $username, $img, $likes)
    {
        $container = "<div style=\"top: 25px; position: relative; display: inline-block\" class=\"border border-5\">";
        $header = "<div class=\"card-header\">
        <i class=\"bi bi-caret-right-fill\"></i>" 
        . htmlspecialchars($username) . "</div>";
        $img = "<img class=\"img-fluid\" src=\"" . htmlspecialchars($img) . "\"><br>";
        
        $icon = "<i style=\"margin-left: 5px;\" class=\"bi bi-suit-heart\">" . htmlspecialchars($likes) . "</i><br>";
        $comment_link = "<a href=\"comments.php?gallery_id=" . htmlspecialchars($gallery_id) . "\">Comments</a>";
        return $container . "\n" . $header . "\n" . $img . "\n" . $icon . "\n" . $comment_link . "</div>\n";
    }


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

    function    renderComment($comment, $username)
    {
        return "<div style=\"margin-top: 40px\" class=\"card\">
        <i class=\"bi bi-caret-right-fill\">" . htmlspecialchars($username) . "</i>
        <div class=\"card-body\">" . htmlspecialchars($comment) . 
        "</div></div>";
    }
?>