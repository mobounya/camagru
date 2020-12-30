<?php
    session_start();
    require_once("./config/setup.php");
    require_once("verifyEmail.php");
    require_once("verification.php");

    function    insert_user($username, $email, $password)
    {
        global $pdo;
    
        $options = [
            'salt' => "THEUNIVERSEI-SEXPANDING",
        ];
        $hashed_pass = password_hash($password, PASSWORD_BCRYPT, $options);
        $sql = "INSERT INTO members (username, email, password) VALUES (:username, :email, :pass)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':username' => $username, ':email' => $email, ':pass' => $hashed_pass));
        return ;
    }

    function    generate_randtoken()
    {
        $token = hash("sha256", random_int(1000, 1000000));
        return ($token);
    }

    function    insertToken($email, $token)
    {
        global $pdo;

        $query = "INSERT INTO email_tokens (email, token) VALUES (:email, :token)";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':email' => $email, ':token' => $token));
        return ;
    }

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
        $token = generate_randtoken();
        insertToken($_POST["email"], $token);
        insert_user($_POST["username"], $_POST["email"], $_POST["pass"]);
        send_Veremail($_POST["email"], $_POST["username"], $token);
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