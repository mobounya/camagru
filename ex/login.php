<?php
    session_start();
    require_once("./config/setup.php");

    if (isset($_POST["email"]) && isset($_POST["pass"]))
    {
        unset($_SESSION["user"]);
        unset($_SESSION["user_id"]);
        $h_pass = hash("md5", "XyZzy12*_".$_POST["pass"]);
        $sql = "SELECT user_id, name, email, password FROM users WHERE email = :email AND password = :pass";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(":email" => $_POST["email"], ":pass" => $h_pass));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row !== false)
        {
            $_SESSION["user"] = $row["name"];
            $_SESSION["user_id"] = $row["user_id"];
            header("Location: index.php");
            return ;
        }
        else
        {
            error_log("Invalid username or password");
            $_SESSION["error"] = "Invalid username or password";
            header("Location: login.php");
            return ;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Mohamed amine Bounya</title>
</head>
<body>
    <script>
        function doValidate() 
        {
            console.log('Validating...');
            $pass = document.getElementById('pass').value;
            $email = document.getElementById('email').value;
            if ($pass == "" || $pass == null || $email == "" || $pass == null)
            {
                alert("Both fields are required");
                return false;
            }
        }
    </script>
    <div style="margin-top: 45px; margin-left: 45px;">
        <h2> Please Log-in </h2>
        <?php
            if (isset($_SESSION["error"]))
            {
                echo '<p style="color: red">' . $_SESSION["error"] . '<p>';
                unset($_SESSION["error"]);
            }
        ?>
        <form method="POST">
            <div>
                <label for="email">E-mail: </label>
                <input type="text" id="email" name="email" style="margin-left: 18px;"> <br>
            </div>
            <div style="margin-top: 7px;">
                <label for="pass">Password: </label>
                <input type="password" id="pass" name="pass">
            </div>
            <input type="submit" onclick="return doValidate();" value="Login" style="margin-top: 10px">
        </form>
    </div>
</body>
</html> 