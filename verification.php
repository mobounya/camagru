<?php
session_start();
require_once("config/constants.php");
require_once(CONFIG_PATH . "/setup.php");

function	setVerified($pdo, $email)
{
	$sql_query = "UPDATE members SET verified=1 WHERE email = :email";
	$stmt = $pdo->prepare($sql_query);
	$stmt->execute(array(":email" => $email));
	$stmt->closeCursor();
}

if (isset($_GET['email']) && isset($_GET['token'])) {
	$query = "SELECT email, token FROM email_tokens WHERE email = :email AND token = :token";
	$stmt = $pdo->prepare($query);
	$stmt->execute(array(':email' => $_GET['email'], ':token' => $_GET['token']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($row == TRUE) {
		$_SESSION["verification"] = "Email confirmed, please log-in";
		$query = "DELETE FROM email_tokens WHERE email = :email AND token = :token";
		$stmt = $pdo->prepare($query);
		$stmt->execute(array(':email' => $_GET['email'], ':token' => $_GET['token']));
		setVerified($pdo, $_GET['email']);
		header("Location: " . PUBLIC_ROOT . "login.php");
		return;
	} else {
		die("Invalid token");
	}
}
