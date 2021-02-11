<?php
    session_start();
    require_once("./getPosts.php");
    if (!isset($_SESSION["member_id"]))
    {
        $_SESSION["error"] = "Please log-in";
        header("Location: login.php");
        return ;
    }
    if (isset($_POST["email"]) || isset($_POST["username"]) || isset($_POST["newpassword1"]) || isset($_POST["notification"]))
    {
        $email = false;
        $username = false;
        $password = false;
        if (!isset($_POST["oldpassword"]) || empty($_POST["oldpassword"]))
        {
            $_SESSION["error"] = "Please provide your old password to save changes.";
            header("Location: profile.php");
            return ;
        }
        

    }
    $profile = getUserDate($_SESSION["member_id"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
	<title><?= $profile[0]["username"]?> Profile</title>
</head>
    <body>
        <main class="container pt-2">
            <div id="avatar" style="display: flex; justify-content: center;">
                <img src="assets/avatar.jpg" alt="Avatar" style="margin: auto; border-radius: 50%;">
            </div>
            <?php
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
                        <input type="text" class="form-control" name="newpassword1" id="newpassword" placeholder="New password">
                        <!-- <input style="margin-top: 15px;" type="text" class="form-control" name="newpassword2" id="newpassword" placeholder="Repeat password"> -->
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="true" name="notification" id="notification">
                        <label class="form-check-label" for="notification">
                            Send notification E-mails
                        </label>
                    </div>
                    <hr/>
                    <div style="margin-top: 50px;" class="form-group">
                        <label for="oldpassword">Enter Password to save changes</label>
                        <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Old password">
                    </div>
                    <button style="margin-top: 20px;" class="btn btn-primary btn-lg btn-block">Save changes</button>
                </form>
            </div>
        </main>
    </body>
</html>