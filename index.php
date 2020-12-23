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
        $sql_query = "SELECT email, password FROM `members` WHERE email = :email AND password = :pass";
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
            $_SESSION["account"] = $_POST["email"];
            header("Location: app.php");
            return ;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log-in</title>
</head>
<body>
    <div style="margin-top: 50px; margin-left: 20px">
        <form method="POST">
            <h2 style="margin-bottom : 30px"> Please Log-in or Create a new account </h2>
            <?php
                if ($_SESSION["error"])
                {
                    echo "<p style=\"color: red\">";
                    echo $_SESSION["error"];
                    echo "</p>";
                    unset($_SESSION["error"]);
                }
            ?>
            <div>
                <label>E-mail</label><input style="margin-left: 28px;" type="text" name="email"><br>
            </div>
            <div>
                <label>Password</label><input style="margin-left: 10px; margin-top: 7px" type="password" name="pass"><br>
            </div>
            <input style="margin-top: 12px;" type="submit" value="Log-in">
        </form>
        <form method="GET" action="register.php">
                <input type="submit" value="Create an account">
        </form>
    </div>
</body>
</html>