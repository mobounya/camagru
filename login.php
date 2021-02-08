<?php
    session_start();
    require_once("verifyEmail.php");
    require_once("./config/setup.php");

    if (isset($_SESSION["account"]))
    {
        header("Location: app.php");
        return ;
    }
    else if (isset($_POST["email"]) && isset($_POST["pass"]))
    {
        if (verifyEmail($_POST["email"]) == FALSE)
            $_SESSION["error"] = "Please enter a valid e-mail address";
        else if ($_POST["pass"] === "")
            $_SESSION["error"] = "Please Enter your Password";
        if (isset($_SESSION["error"]))
        {
            header("Location: index.php");
            return ;
        }
        $options = [
            'salt' => "THEUNIVERSEI-SEXPANDING",
        ];
        $hashed_password = password_hash($_POST["pass"], PASSWORD_BCRYPT, $options);
        $sql_query = "SELECT member_id, email, username, password FROM `members` WHERE email = :email AND password = :pass";
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(array(':email' => $_POST["email"], ':pass' => $hashed_password));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === FALSE)
        {
            $_SESSION["error"] = "Please check your entries and try again.";
            header("Location: index.php");
            return ;
        }
        else
        {
            $_SESSION["account"] = $row["email"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["member_id"] = $row["member_id"];
            header("Location: app.php");
            return ;
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
            <?php
                if (isset($_SESSION["error"]))
                {
                    echo "<p style=\"color: red\">";
                    echo $_SESSION["error"];
                    echo "</p>";
                    unset($_SESSION["error"]);
                }
            ?>
        <div style="display: inline-block;">
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="pass">
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