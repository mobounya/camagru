<?php
    session_start();
    require_once("./config/setup.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Moahmed amine Bounya</title>
        <style>
            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
        </style>
    </head>
<body>
    <?php
        $sql_query = "SELECT profile_id, first_name, last_name, headline, user_id FROM `Profile`";
        $stmt = $pdo->prepare($sql_query);
        $stmt->execute();
    ?>
    <div style="margin-top: 60px; margin-left: 50px;">
        <h2>Mohamed amine bounya resume registry</h2>
        <?php
            if (isset($_SESSION["user"]))
                echo "<p><a href='logout.php'>Logout</a></p>";
            if (isset($_SESSION["error"]))
            {
                echo '<p style="color: red">' . $_SESSION["error"] . '<p>';
                unset($_SESSION["error"]);
            }
            else if (isset($_SESSION["success"]))
            {
                echo '<p style="color: green">' . $_SESSION["success"] . '<p>';
                unset($_SESSION["success"]);
            }
        ?>
        <table style="border: 1px solid black; border-spacing: 5px;">
            <tr>
                <th>Name</th>
                <th>Headline</th>
                <?php
                    if (isset($_SESSION["user_id"]))
                        echo "<th>Action</th>";
                ?>
            </tr>
            <?php
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    echo "<tr>"; 
                    echo '<td><a href="view.php?profile_id='. $row["profile_id"] .'">' . $row["first_name"] . " " . $row["last_name"] . "</a></td>";
                    echo "<td>" . $row["headline"] . "</td>";
                    if (isset($_SESSION["user_id"]) && $row["user_id"] === $_SESSION["user_id"])
                    {
                        echo "<td>";
                        echo "<p><a href=\"edit.php?profile_id=" . $row["profile_id"] . "\">Edit</a>";
                        echo "<a href=\"delete.php?profile_id=" . $row["profile_id"] . "\"> Delete</a></p>";
                        echo "</td>";
                    }
                    echo "</tr>";
                }
            ?>
        </table>
        <?php
            echo "<p>";
            if (isset($_SESSION["user"]))
                echo "<a href='add.php'> Add new entry";
            else
                echo "<a href='login.php'>Login";
            echo "</a></p>"
        ?>
    </div>
</body>
</html> 