<?php
session_start();
require_once("./getPosts.php");
require_once("./utils.php");
require_once("./verifyUserData.php");
require_once("./config/setup.php");

if (!isset($_SESSION["member_id"])) {
    $_SESSION["error"] = "Please log-in";
    header("Location: login.php");
    return;
}
if (isset($_POST["email"]) || isset($_POST["username"]) || isset($_POST["newpassword1"]) || isset($_POST["notification"])) {
    $email = "";
    $username = "";
    $password = "";
    if (!isset($_POST["oldpassword"]) || empty($_POST["oldpassword"])) {
        $_SESSION["error"] = "Please provide your old password to save changes.";
        header("Location: profile.php");
        return;
    } else if (comparePassword($pdo, $_SESSION["member_id"], $_POST["oldpassword"]) == false) {
        $_SESSION["error"] = "Wrong Password, please try again!";
        header("Location: profile.php");
        return;
    }
    if (isset($_POST["email"]) && !empty($_POST["email"])) {
        if (verifyEmail($_POST["email"]) === false) {
            $_SESSION["error"] = "Please enter a valid E-mail address";
            header("Location: profile.php");
            return;
        }
        updateEmail($pdo, $_SESSION["member_id"], $_POST["email"]);
        $email = "E-mail";
    }
    if (isset($_POST["username"]) && !empty($_POST["username"])) {
        updateUsername($pdo, $_SESSION["member_id"], $_POST["username"]);
        $username = "Username";
    }
    if (isset($_POST["newpassword1"]) && !empty($_POST["newpassword1"])) {
        updatePassword($pdo, $_SESSION["member_id"], $_POST["newpassword1"]);
        $password = "Password";
    }
    $_SESSION["success"] = "Data changed successfully";
    header("Location: profile.php");
    return;
}
$profile = getUserDate($_SESSION["member_id"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <title><?= $profile[0]["username"] ?> Profile</title>
</head>

<body>
    <main class="container pt-2">
        <div id="avatar" style="display: flex; justify-content: center;">
            <img src="assets/avatar.jpg" alt="Avatar" style="margin: auto; border-radius: 50%;">
        </div>
        <?php
        flashMessage();
        ?>
        <div class="px-2 mt-5">
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $profile[0]["email"] ?>">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= $profile[0]["username"] ?>">
                </div>
                <div class="form-group">
                    <label for="newpassword">New password</label>
                    <div data-role="input-password">
                        <input type="password" class="form-control" name="newpassword1" placeholder="New password" />
                        <div style="margin-top: 15px;" class="form-check form-switch">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" />
                                Show Password
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="true" name="notification" id="notification">
                    <label class="form-check-label" for="notification">
                        Send notification E-mails
                    </label>
                </div>
                <hr />
                <div style="margin-top: 50px;" class="form-group">
                    <label for="oldpassword">Enter Password to save changes</label>
                    <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Old password">
                </div>
                <button style="margin-top: 20px;" class="btn btn-primary btn-lg btn-block">Save changes</button>
            </form>
        </div>
    </main>
</body>
<script type="text/javascript" src="js/utils.js"></script>

</html>