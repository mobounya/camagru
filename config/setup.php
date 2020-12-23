<?php
    require_once("database.php");
    $pdo = new pdo($DB_DSN, $DB_USER, $DB_PASSWORD);
    $pdo->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>