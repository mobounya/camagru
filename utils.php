<?php
    // Delete all comments from post.
    function    deleteComments($pdo, $gallery_id)
    {
        $sql_query = "DELETE FROM `comments` WHERE gallery_id = :gl_id";
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(array(
            ":gl_id" => $gallery_id
        ));
        $stmt->closeCursor();
    }

    // Delete Post.
    function    deletePost($pdo, $gallery_id)
    {
        deleteComments($pdo, $gallery_id);
        $sql_query = "DELETE FROM `gallery` WHERE gallery_id = :gl_id";
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(array(
            ":gl_id" => $gallery_id
        ));
        $stmt->closeCursor();
    }

    // Get Post owner info.
    function    getPostOwner($pdo, $gallery_id)
    {
        $sql_query = "SELECT gallery.member_id, username, email FROM gallery INNER JOIN members ON 
                gallery.member_id=members.member_id WHERE gallery_id = :gl_id";
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(array(
            ":gl_id" => $gallery_id
        ));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

    // Compare password
    function    comparePassword($pdo, $password)
    {
        
    }
?>