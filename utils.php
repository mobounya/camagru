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
    function    comparePassword($pdo, $member_id, $password)
    {
        $options = [
            'salt' => "THEUNIVERSEI-SEXPANDING",
        ];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);
        $sql_query = "SELECT * FROM `members` WHERE password = :pass AND member_id = :id";
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(array(
            ':pass' => $hashed_password,
            ':id' => $member_id
        ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if ($row === FALSE)
            return FALSE;
        else
            return TRUE;
    }

    function    updateEmail($pdo, $member_id, $email)
    {
        $sql_query = "UPDATE `members` SET email=:email WHERE member_id=:id";
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(array(
            ':email' => $email,
            ':id' => $member_id
        ));
    }

    function    updateUsername($pdo, $member_id, $username)
    {
        $sql_query = "UPDATE `members` SET username=:username WHERE member_id=:id";
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(array(
            ':username' => $username,
            ':id' => $member_id
        ));
    }

    function    updatePassword($pdo, $member_id, $password)
    {
        $options = [
            'salt' => "THEUNIVERSEI-SEXPANDING",
        ];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);
        $sql_query = "UPDATE `members` SET password=:pass WHERE member_id=:id";
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(array(
            ':pass' => $hashed_password,
            ':id' => $member_id
        ));
    }

    function    flashMessage()
    {
        if (isset($_SESSION["success"]))
        {
            echo "<div class=\"alert alert-success mt-5\" role=\"alert\">
                {$_SESSION["success"]}
            </div>";
            unset($_SESSION["success"]);
        }
        else if (isset($_SESSION["error"]))
        {
            echo "<div class=\"alert alert-danger mt-5\" role=\"alert\">
            {$_SESSION["error"]}
            </div>";
            unset($_SESSION["error"]);
        }
        else if (isset($_SESSION["verification"]))
        {
            echo "<p style=\"color: red\">";
            echo $_SESSION["verification"];
            echo "</p>";
            unset($_SESSION["verification"]);
        }
    }
?>