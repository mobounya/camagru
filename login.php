<?php
session_start();
require_once("./verifyUserData.php");
require_once("./config/setup.php");
require_once("./utils.php");

if (isset($_SESSION["account"])) {
    header("Location: app.php");
    return;
} else if (isset($_POST["email"]) && isset($_POST["pass"])) {
    if (verifyEmail($_POST["email"]) == false || verifyPassword($_POST["pass"]) == false) {
        header("Location: login.php");
        return;
    }
    $row = CheckLoginEntries($pdo, $_POST["email"], $_POST["pass"]);
    if ($row === FALSE) {
        $_SESSION["error"] = "Please check your entries and try again.";
        header("Location: login.php");
        return;
    } else {
        if ($row["verified"] == false) {
            $_SESSION["verification"] = "Please confirm your email to log-in";
            header("Location: login.php");
            return;
        }
        $_SESSION["account"] = $row["email"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["member_id"] = $row["member_id"];
        $_SESSION["success"] = "Logged in successfully";
        header("Location: index.php");
        return;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="styling/app.css" rel="stylesheet">
    <title>Log-in</title>
</head>

<body>
    <div style="margin-top: 50px; margin-left: 20px">
        <form method="POST">
            <h2 style="margin-bottom : 30px"> Please Log-in or Create a new account </h2>
            <div style="display: inline-block;">
                <?php
                flashMessage();
                ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="pass">
                        <a style="margin-top: 0px;" href="reset.php"> Reset password </a>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">Log-in</button>
                    </div>
                </form>
            </div>
            <form action="./register.php" method="GET">
                <button type="submit" class="btn btn-primary mb-3">Create account</button>
            </form>
</body>

</html>