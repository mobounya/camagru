<?php
    session_start();
    require_once("./config/setup.php");
    if (!isset($_SESSION["user_id"]))
    {
        die("ACCESS DENIED");
        return ;
    }
    if (isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"]) &&
        isset($_POST["profile_id"]) && isset($_POST["headline"]) && isset($_POST["summary"]))
    {
        $query = "UPDATE `Profile` SET first_name = :fn, last_name = :ln, email = :em, headline = :hd, summary = :sm WHERE profile_id = :pf_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(
            ":fn" => $_POST["first_name"],
            ":ln" => $_POST["last_name"],
            ":em" => $_POST["email"],
            ":hd" => $_POST["headline"],
            ":sm" => $_POST["summary"],
            ":pf_id" => $_POST["profile_id"]
        ));
        $_SESSION["success"] = "Profile edited successfully";
        header("Location: index.php");
        return ;
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Add profile</title>
</head>
<body>
    <?php
        if (isset($_GET['profile_id']))
        {
            $sql_query = "SELECT profile_id, first_name, last_name, email, headline, summary, user_id FROM `Profile` WHERE profile_id = :profile_id";
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
                $_SESSION["error"] = "You don't have permission to edit this profile.";
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
    <div style="margin-left: 50px; margin-top: 60px">
        <h2>Editing Profile for <?= $_SESSION["user"] ?> </h2>
        <form method="POST">
            <label for="first">First name: </label>
            <?= '<input type="text" id="first" name="first_name" value="' . $row["first_name"]  .'"><br>' ?>
            <div style="margin-top: 7px;">
                <label for="last">Last name: </label>
                <?= '<input type="text" id="last" name="last_name" value="' . $row["last_name"] . '"><br>' ?>
            </div>
            <div style="margin-top: 7px;">
                <label for="email" style="margin-right: 21px;">E-mail: </label>
                <?= '<input type="text" id="email" name="email" value="' . $row["email"] . '"><br>' ?>
            </div>
            <div style="margin-top: 7px;">
                <label for="headline">Headline: </label> <br>
                <?= '<input type="text" id="headline" name="headline" value="' . $row["headline"] . '"><br>' ?>
            </div>
            <div style="margin-top: 7px;">
                <label for="summary">Summary: </label> <br>
                <?= '<textarea id="summary" name="summary" rows="4" cols="50">' . $row["summary"] . '</textarea>' ?>
            </div>
            <?= '<input type="hidden" name="profile_id" value="' .  $row["profile_id"] . '">'?>
            <input type="submit" value="Edit" style="margin-top: 15px;">
        </form>
    </div>
</body>
</html> 