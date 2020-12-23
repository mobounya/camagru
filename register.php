<?php
    session_start();
    require_once("./config/setup.php");
    require_once("verifyEmail.php");

    if (isset($_SESSION["account"]))
    {
        header("Location: app.php");
        return ;
    }
    if (isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["pass"]))
    {
        if (verifyEmail($_POST["email"]) == FALSE)
        {
            $_SESSION["error"] = "Please enter a valid e-mail address";
            header("Location: register.php");
            return;
        }
        $options = [
            'salt' => "THEUNIVERSEI-SEXPANDING",
        ];
        $hashed_pass = password_hash($_POST["pass"], PASSWORD_BCRYPT, $options);
        $sql = "INSERT INTO members (username, email, password) VALUES (:username, :email, :pass)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':username' => $_POST['username'], ':email' => $_POST['email'], ':pass' => $hashed_pass));
        header("Location: index.php");
        return ;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create an Account</title>
</head>
<body>
    <div style="margin-top: 50px; margin-left: 30px">
        <h2>Create an account: </h2>
        <?php
            if (isset($_SESSION["error"]))
            {
                echo "<p style=\"color: red\">" . $_SESSION["error"] . "</p>";
                unset($_SESSION["error"]);
            }
        ?>
        <form method="POST">
            <label>E-mail: </label> <input style="margin-left: 26px;" type="text" name="email"><br>
            <label>Username: </label> <input style="margin-left: 5px; margin-top: 7px" type="text" name="username"><br>
            <label>Password: </label> <input style="margin-left: 8px; margin-top: 7px" type="password" name="pass"> <br>
            <input style="margin-top: 15px" type="submit" value="Create account">
        </form>
    </div>
</body>
</html>