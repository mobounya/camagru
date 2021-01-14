<?php
    session_start();
    require_once("./config/setup.php");
    header("Content-Type: application/json");
    $sql_query = "SELECT profile_id, first_name, last_name, headline, user_id FROM `Profile`";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute();
    $rows = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        $rows[] = $row;

    echo json_encode($rows);
?>