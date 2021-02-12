<?php
    require_once("./config/setup.php");

    $sql_query = "SELECT * FROM gallery WHERE member_id=:id";
    $stmt = $pdo->prepare($sql_query);
    $stmt->execute(array(
        ":id" => 3
    ));
    var_dump($stmt);
?>