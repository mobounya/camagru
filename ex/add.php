<?php
    session_start();
    require_once("./config/setup.php");
    if (isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"]) && isset($_POST["headline"]) && isset($_POST["summary"]))
    {
        $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES ( :uid, :fn, :ln, :em, :he, :su)');
      
      $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary']));
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Add profile</title>
</head>
<body>
    <div style="margin-left: 50px; margin-top: 60px">
        <h2>Adding Profile for <?= $_SESSION["user"] ?> </h2>
        <form method="POST">
            <label for="first">First name: </label>
            <input type="text" id="first" name="first_name"> <br>
            <div style="margin-top: 7px;">
                <label for="last">Last name: </label>
                <input type="text" id="last" name="last_name"> <br>
            </div>
            <div style="margin-top: 7px;">
                <label for="email" style="margin-right: 21px;">E-mail: </label>
                <input type="text" id="email" name="email"> <br>
            </div>
            <div style="margin-top: 7px;">
                <label for="headline">Headline: </label> <br>
                <input type="text" id="headline" name="headline"> <br>
            </div>
            <div style="margin-top: 7px;">
                <label for="summary">Summary: </label> <br>
                <textarea id="w3review" name="summary" rows="4" cols="50"></textarea>
            </div>
            <input type="submit" value="Add" style="margin-top: 15px;">
        </form>
    </div>
</body>
</html> 