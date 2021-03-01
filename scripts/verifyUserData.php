<?php
function    verifyEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
        $_SESSION["error"] = "Please enter a valid e-mail address";
        return false;
    } else
        return true;
}

function    verifyUsername($username)
{
    $username = trim($username);
    if (strlen($username) < 6) {
        $_SESSION["error"] = "Username should be at least 6 characters";
        return false;
    }
    return true;
}

function    verifyPassword($password)
{
    $requirements = "Password should be at least 8 characters, at least 2 special character, 2 uppercase, 2 digits";
    if (strlen($password) < 8) {
        $_SESSION["error"] = "Password should be at least 8 characters";
        return false;
    }

    $pattern = '/[^a-zA-Z0-9]/';
    $matches = preg_match_all($pattern, $password);
    if ($matches < 1) {
        $_SESSION["error"] = $requirements;
        return false;
    }
    $pattern = '/[0-9]/';
    $matches = preg_match_all($pattern, $password);
    if ($matches < 1) {
        $_SESSION["error"] = $requirements;
        return false;
    }
    $pattern = '/[A-Z]/';
    $matches = preg_match_all($pattern, $password);
    if ($matches < 1) {
        $_SESSION["error"] = $requirements;
        return false;
    }
    return true;
}
