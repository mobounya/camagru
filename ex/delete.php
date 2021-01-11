<?php
    session_start();
    require_once("./config/setup.php");
    if (!isset($_SESSION["user_id"]))
    {
        die("ACCESS DENIED");
        return ;
    }
    if (isset($_POST['profile_id']))
    {
        $sql_delete = "DELETE FROM `Profile` WHERE profile_id = :pf_id";
        $stmt = $pdo->prepare($sql_delete);
        $stmt->execute(array(
            ":pf_id" => $_POST['profile_id']
        ));
        $_SESSION["success"] = "Profile Deleted";
        header("Location: index.php");
        return ;
    }
    else if (isset($_GET['profile_id']))
    {
        $sql_query = "SELECT profile_id, user_id, first_name, last_name FROM `Profile` WHERE profile_id = :profile_id";
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute(array(
            ":profile_id" => $_GET['profile_id']
        ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false)
        {
            $_SESSION["error"] = "Selected profile doesn't exist";
            header("Location: index.php");
            return ;
        }
        if ($row["user_id"] !== $_SESSION["user_id"])
        {
            $_SESSION["error"] = "You don't have permission to delete this profile.";
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
    <div style="margin-top: 44px; margin-left: 44px;">
        <h2>Deleteing Profile</h2>
        <?php
            echo "<p>First Name: {$row['first_name']}</p>";
            echo "<p>Last Name: {$row['last_name']}</p>";
        ?>
        <form method="POST">
            <input type="submit" name="delete" value="Delete">
            <?= '<input type="hidden" name="profile_id" value="' . $row['profile_id'] . '">' ?>
        </form>
    </div>
</body>
</html> 