<?php
session_start();
require_once("config/constants.php");
require_once(CONFIG_PATH . "/setup.php");
require_once(SCRIPTS_PATH . "/getPosts.php");
require_once(SCRIPTS_PATH . "/utils.php");

// Check if token exist in reset table
function    checkResetToken($pdo, $email, $token)
{
    $sql_query = "SELECT * FROM reset WHERE email=:email AND token=:token";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":email" => $email,
        ":token" => $token
    ));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if ($data === false)
        return false;
    else
        return $data;
}

// Delete reset entry
function    deleteResetToken($pdo, $email, $token)
{
    $sql_query = "DELETE FROM reset WHERE email=:email AND token=:token";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":email" => $email,
        ":token" => $token
    ));
    $stmt->closeCursor();
}

if (isset($_POST["newpass"]) && isset($_POST["email"]) && isset($_POST["token"])) {
    if (checkResetToken($pdo, $_POST["email"], $_POST["token"]) === false) {
        die("invalid token");
    }
    deleteResetToken($pdo, $_POST["email"], $_POST["token"]);
    $userData = getUserByEmail($_POST["email"]);
    updatePassword($pdo, $userData[0]["member_id"], $_POST["newpass"]);
    $_SESSION["success"] = "Password changed successfully, please log-in";
    header("Location: " . PUBLIC_ROOT . "login.php");
    return;
} else if (isset($_GET["email"]) && isset($_GET["token"])) {
    if (checkResetToken($pdo, $_GET["email"], $_GET["token"]) === false) {
        die("invalid token");
    }
} else {
    header("Location: " . PUBLIC_ROOT . "login.php");
    return;
}

setHtmlSpecialChars($_GET, ["email", "token"]);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="styling/app.css" rel="stylesheet">
    <title>Reset Password</title>
</head>

<body>
    <div style="display: inline-block;">
        <form method="POST">
            <div class="form-group">
                <label for="newpass">New Password</label>

                <div data-role="input-password">
                    <input type="password" class="form-control" id="newpass" name="newpass" id="newpass">
                    <div style="margin-top: 15px;" class="form-check form-switch">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" />
                            Show Password
                        </label>
                    </div>
                </div>

                <input type="hidden" class="form-control" name="email" value="<?= $_GET["email"] ?>">
                <input type="hidden" class="form-control" name="token" value="<?= $_GET["token"] ?>">
                <button style="margin-top: 10px;" class="btn btn-primary">Reset Password</button>
            </div>
        </form>
        <div>
</body>
<script type="text/javascript" src="js/utils.js"></script>

</html>