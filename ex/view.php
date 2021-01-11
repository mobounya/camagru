<?php
    session_start();
    require_once("./config/setup.php");
    if (isset($_GET['profile_id']))
    {
        $sql_query = "SELECT first_name, last_name, email, headline, summary FROM Profile WHERE profile_id = :pf_id";
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(array(
            ":pf_id" => $_GET['profile_id']
        ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false)
        {
            $_SESSION["error"] = "Selected profile doesn't exist";
            header("Location: index.php");
            return ;
        }
    }
    else
    {
        $_SESSION["error"] = "No profile provided";
        header("Location: index.php");
        return ;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Moahmed amine Bounya</title>
    </head>
<body>
    <div style="margin-top: 70px; margin-left: 70px;">
        <h2>Profile Information </h2>
        <?php
            echo '<p>First name: ' . $row["first_name"] . '</p>';
            echo '<p>Last Name: ' . $row["last_name"] . '</p>';
            echo '<p>E-mail: ' . $row["email"] . '</p>';
            echo '<p> Headline: ' . $row["headline"] . '</p>';
            echo '<p> Summary: ' . $row["summary"] . '</p>';
        ?>
        <a href="index.php"><input type="submit" value="Done"></a>
    </div>
</body>
</html> 