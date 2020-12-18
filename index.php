<?php
    session_start();
    if (isset($_SESSION["account"]))
    {
        header("Location: app.php");
        return ;
    }
    else if (isset($_POST["email"]) && isset($_POST["pass"]))
    {
        if ($_POST["email"] === "")
            $_SESSION["error"] = "Please enter your E-mail";
        else if ($_POST["pass"] === "")
            $_SESSION["error"] = "Please Enter your Password";
        if (isset($_SESSION["error"]))
        {
            header("Location: index.php");
            return ;
        }
        if ($_POST[pass] === "1337")
        {
            $_SESSION["account"] = $_POST["email"];
            header("Location: app.php");
            return ;
        }
        else
        {
            $_SESSION["error"] = "Incorrect Password";
            header("Location: index.php");
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