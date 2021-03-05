<?php
require_once("database.php");

$pdo = new PDO("mysql:host=mysql;port=3306", $DB_USER, $DB_PASSWORD);
$pdo->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// build database and tables.
$pdo->query(file_get_contents(CONFIG_PATH . "/initSetup.sql"));
