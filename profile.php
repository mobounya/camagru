<?php
session_start();
require_once("config/constants.php");
require_once(SCRIPTS_PATH . "/getPosts.php");
require_once(SCRIPTS_PATH . "/utils.php");
require_once(SCRIPTS_PATH . "/verifyUserData.php");
require_once(CONFIG_PATH . "/setup.php");

if (!isset($_SESSION["member_id"])) {
    $_SESSION["error"] = "Please log-in";
    header("Location: " . PUBLIC_ROOT . "login.php");
    return;
}

function buildUpdateUserQuery($keys)
{
    $query = 'UPDATE `members` SET';

    foreach ($keys as $key) {
        $query .= " `$key` = :$key,";
    }
    $query = substr($query, 0, strlen($query) - 1);
    $query .= " WHERE member_id = :id";
    return $query;
}

if (isset($_POST["email"]) || isset($_POST["oldpassword"]) || isset($_POST["username"]) || isset($_POST["newpassword1"]) || isset($_POST["notification"])) {
    $fields = [];

    if (!isset($_POST["oldpassword"]) || empty($_POST["oldpassword"])) {
        $_SESSION["error"] = "Please provide your old password to save changes.";
        header("Location: " . PUBLIC_ROOT . "profile.php");
        return;
    } else if (CheckLoginEntries($pdo, $_POST["email"], $_POST["oldpassword"]) == false) {
        $_SESSION["error"] = "Wrong Password, please try again!";
        header("Location: " . PUBLIC_ROOT . "profile.php");
        return;
    }

    if (isset($_POST["email"]) && !empty($_POST["email"])) {
        if (verifyEmail($_POST["email"]) === false) {
            $_SESSION["error"] = "Please enter a valid E-mail address";
            header("Location: " . PUBLIC_ROOT . "profile.php");
            return;
        }
        $fields["email"] = $_POST["email"];
    }
    if (isset($_POST["username"]) && !empty($_POST["username"])) {
        if (verifyUsername($_POST["username"])) {
            $fields["username"] = $_POST["username"];
        }
    }
    if (isset($_POST["newpassword1"]) && !empty($_POST["newpassword1"])) {
        $fields["password"] =  hashPassword($_POST["newpassword1"]);
    }
    if (isset($_POST["notification"])) {
        $fields["notification"] = 1;
    } else {
        $fields["notification"] = 0;
    }
    $queryString = buildUpdateUserQuery(array_keys($fields));
    $fields["id"] = $_SESSION["member_id"];
    $stmt = $pdo->prepare($queryString);
    array_foreach(function ($key, $value) {
        global $stmt;
        $stmt->bindParam(":$key", $value);
    }, $fields);
    $stmt->execute();
    $stmt->closeCursor();
    $_SESSION["success"] = "Data changed successfully";
    header("Location: " . PUBLIC_ROOT . "profile.php");
    return;
}
$profile = getUserData($_SESSION["member_id"]);
if ($profile["notification"])
    $checked = "checked";
else
    $checked = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <title><?= $profile["username"] ?> Profile</title>
</head>

<body>
    <main class="container">
        <div class="ft_navbar">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="app.php">App</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
        <div id="avatar" style="display: flex; justify-content: center; margin-top: 16px;">
            <img src="assets/avatar.jpg" alt="Avatar" style="margin: auto; border-radius: 50%;">
        </div>
        <?php
        flashMessage();
        ?>
        <div class="px-2 mt-5">
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $profile["email"] ?>">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= $profile["username"] ?>">
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
                    <input class="form-check-input" type="checkbox" value="true" name="notification" id="notification" <?= $checked ?> />
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