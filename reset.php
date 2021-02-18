<?php
session_start();
require_once("./utils.php");
require_once("./config/setup.php");
require_once("./verifyUserData.php");

// check if user already asked for a reset email.
function    checkReset($pdo, $email)
{
    $sql_query = "SELECT * FROM reset WHERE email=:email";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":email" => $email
    ));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if ($data === false)
        return false;
    else
        return true;
}

function    updateResetToken($pdo, $email, $token)
{
    $sql_query = "UPDATE reset SET token=:token WHERE email=:email";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":token" => $token,
        ":email" => $email
    ));
}

if (isset($_SESSION["account"])) {
    header("Location: index.php");
    return;
}
if (isset($_POST["email"])) {
    if (verifyEmail($_POST["email"]) === false) {
        $_SESSION["error"] = "Please enter a valid E-mail address";
        header("location: reset.php");
        return;
    }
    if (CheckEmail($pdo, $_POST["email"]) !== false) {
        $token = generate_randtoken();
        if (checkReset($pdo, $_POST["email"]) === true)
            updateResetToken($pdo, $_POST["email"], $token);
        else
            insertResetToken($pdo, $_POST["email"], $token);
        SendResetEmail($_POST["email"], $token);
    }
    $_SESSION["alert"] = "Reset email is sent if E-mail provided exists, check your email to reset your password";
    header("Location: login.php");
    return;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="styling/app.css" rel="stylesheet">
    <title>Reset Password</title>
</head>

<body>
    <div style="display: inline-block;">
        <?php
        flashMessage();
        ?>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <button class="btn btn-primary">Reset</button>
        </form>
        <div>
</body>

</html>