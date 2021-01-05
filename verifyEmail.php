<?php
    function verifyEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
            return FALSE;
        else
            return TRUE;
    }
?>