<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create an Account</title>
</head>
<body>
    <div style="margin-top: 50px; margin-left: 30px">
        <h2>Create an account: </h2>
        <form method="POST">
            <label>E-mail: </label> <input style="margin-left: 26px;" type="text" name="email"><br>
            <label>Username: </label> <input style="margin-left: 5px; margin-top: 7px" type="text" name="username"><br>
            <label>Password: </label> <input style="margin-left: 8px; margin-top: 7px" type="password" name="pass">
        </form>
    </div>
</body>
</html>