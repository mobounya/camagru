<?php
require_once("./config/setup.php");

function    send_Veremail($email, $username, $token)
{
	$subject = "Please verify your email";
	$message = "Hi $username\n
		Please verify your e-mail using this link:\n
		http://{$_SERVER["SERVER_NAME"]}:8080/verification.php?email=$email&token=$token";
	mail($email, $subject, $message);
}

if (isset($_GET['email']) && isset($_GET['token'])) {
	$query = "SELECT email, token FROM email_tokens WHERE email = :email AND token = :token";
	$stmt = $pdo->prepare($query);
	$stmt->execute(array(':email' => $_GET['email'], ':token' => $_GET['token']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($row == TRUE) {
		$_SESSION["verification"] = "E-mail ({$_GET['email']}) confirmed";
		$query = "DELETE FROM email_tokens WHERE email = :email AND token = :token";
		$stmt = $pdo->prepare($query);
		$stmt->execute(array(':email' => $_GET['email'], ':token' => $_GET['token']));
		header("Location: app.php");
		return;
	} else {
		header("Location: index.php");
		return;
	}
}
