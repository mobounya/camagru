<?php
    function    send_Veremail($email, $username, $token)
    {
		$subject = "Please verify your email";
		$message = "Hi $username\n
		Please verify your e-mail using this link:\n
		http://192.168.99.107:8080/verification.php?token=$token";

    }

?>