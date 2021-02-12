<?php
    function    verifyEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
        {
            $_SESSION["error"] = "Please enter a valid e-mail address";
            return false;
        }
        else
            return true;
    }

    function    verifyUsername($username)
    {
        $username = trim($username);
        if (strlen($username) < 6)
        {
            $_SESSION["error"] = "Username should be at least 6 characters";
            return false;
        }
        return true;
    }

    function    verifyPassword($password)
    {
        // regex
        if ($password === "")
        {
            $_SESSION["error"] = "Please enter your password";
            return false;
        }
        return true;
    }
?>