<?php
function    hashPassword($password)
{
    $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
    return $hashed_pass;
}

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

// Update member id email
function    updateEmail($pdo, $member_id, $email)
{
    $sql_query = "UPDATE `members` SET email=:email WHERE member_id=:id";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ':email' => $email,
        ':id' => $member_id
    ));
    $stmt->closeCursor();
}

// Update member id username
function    updateUsername($pdo, $member_id, $username)
{
    $sql_query = "UPDATE `members` SET username=:username WHERE member_id=:id";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ':username' => $username,
        ':id' => $member_id
    ));
    $stmt->closeCursor();
}

// Update member id password
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
    $stmt->closeCursor();
}

function    flashMessage()
{
    if (isset($_SESSION["success"])) {
        echo "<div class=\"alert alert-success mt-5\" role=\"alert\">
                {$_SESSION["success"]}
            </div>";
        unset($_SESSION["success"]);
    } else if (isset($_SESSION["error"])) {
        echo "<div class=\"alert alert-danger mt-5\" role=\"alert\">
            {$_SESSION["error"]}
            </div>";
        unset($_SESSION["error"]);
    } else if (isset($_SESSION["verification"])) {
        echo "<p style=\"color: red\">";
        echo $_SESSION["verification"];
        echo "</p>";
        unset($_SESSION["verification"]);
    } else if (isset($_SESSION["alert"])) {
        echo "<div class=\"alert alert-primary\" role=\"alert\">";
        echo $_SESSION["alert"];
        echo "</div>";
        unset($_SESSION["alert"]);
    }
}

// Check if login credentials exist in database
// return userdata if exist else return false
// NOTE : this function does not log user in.
function    CheckLoginEntries($pdo, $email, $pass)
{
    $sql_query = "SELECT member_id, email, username, verified, password FROM `members` 
                    WHERE email = :email";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ':email' => $email,
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if (password_verify($pass, $row["password"]) == true)
        return $row;
    else
        return false;
}

// Check if email is registed on the members table.
function    CheckEmail($pdo, $email)
{
    $sql_query = "SELECT * FROM members WHERE email=:email";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":email" => $email,
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if ($row === false)
        return (false);
    else
        return $row;
}

// Generate a random token
function    generate_randtoken()
{
    $token = hash("sha256", random_int(1000, 1000000));
    return ($token);
}

// Insert token into reset table
function    insertResetToken($pdo, $email, $token)
{
    $sql_query = "INSERT INTO reset(email, token) VALUES(:email, :token)";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":email" => $email,
        ":token" => $token
    ));
    $stmt->closeCursor();
}

// Send email token
function    SendResetEmail($email, $token)
{
    $subject = "Reset your password";
    $message = "Please reset your password using this link:\n
        https://{$_SERVER["SERVER_NAME"]}/changePassword.php?email=$email&token=$token";
    mail($email, $subject, $message);
}

function    setHtmlSpecialChars($array, $keys = null)
{
    foreach ($array as $key => $value) {
        $can_set = true;
        if (!$keys) {
            $can_set = in_array($key, $keys);
        }

        if ($can_set) {
            $array[$key] = htmlspecialchars($value);
        }
    }
}

// Get the number of likes in a post(gallery_id)
function    getLikes($pdo, $gallery_id)
{
    $sql_query = "SELECT likes FROM gallery WHERE gallery_id=:g_id";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        "g_id" => $gallery_id
    ));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $data["likes"];
}

// Get user data from members table by username
function    getByusername($pdo, $username)
{
    $sql_query = "SELECT * FROM members WHERE username=:usnm";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":usnm" => $username
    ));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $data;
}

// Check if post is liked by specified member (member_id)
function    isLiked($pdo, $member_id, $gallery_id)
{
    $sql_query = "SELECT * FROM likes WHERE member_id=:m_id AND gallery_id=:gl_id";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":m_id" => $member_id,
        ":gl_id" => $gallery_id,
    ));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if (empty($data))
        return false;
    else
        return true;
}

function array_foreach($callback, $array)
{
    foreach ($array as $key => $value) {
        $callback($key, $value);
    }
}

// if (!isset($_POST["oldpassword"]) || empty($_POST["oldpassword"])) {
//     $_SESSION["error"] = "Please provide your old password to save changes.";
//     header("Location: profile.php");
//     return;
// } else if (comparePassword($pdo, $_SESSION["member_id"], $_POST["oldpassword"]) == false) {
//     $_SESSION["error"] = "Wrong Password, please try again!";
//     header("Location: profile.php");
//     return;
// }
// if (isset($_POST["email"]) && !empty($_POST["email"])) {
//     if (verifyEmail($_POST["email"]) === false) {
//         $_SESSION["error"] = "Please enter a valid E-mail address";
//         header("Location: profile.php");
//         return;
//     }
//     updateEmail($pdo, $_SESSION["member_id"], $_POST["email"]);
// }
// if (isset($_POST["username"]) && !empty($_POST["username"])) {
//     updateUsername($pdo, $_SESSION["member_id"], $_POST["username"]);
// }
// if (isset($_POST["newpassword1"]) && !empty($_POST["newpassword1"])) {
//     updatePassword($pdo, $_SESSION["member_id"], $_POST["newpassword1"]);
// }
// if (isset())