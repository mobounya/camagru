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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="styling/app.css" rel="stylesheet">
    <title>Create an Account</title>
</head>
<body>
    <div style="display: inline-block; margin-top: 50px; margin-left: 30px">
        <h2>Create an account</h2>
        <?php
            if (isset($_SESSION["error"]))
            {
                echo "<p style=\"color: red\">" . $_SESSION["error"] . "</p>";
                unset($_SESSION["error"]);
            }
        ?>
        <div id="registerForm">
            <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="text" class="form-control" name="email">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input id="username" type="text" class="form-control" name="username">
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input id="pass" type="password" class="form-control" name="pass">
            </div>
            <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">Create account</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>