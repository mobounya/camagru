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
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
    </script>
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
            <tbody id="tbody">
            </tbody>
        </table>
        <script type="text/javascript">
            $.getJSON('get_json.php', function (data)
            {
                $("#tbody").empty();
                console.log("got json data");
                console.log(data);
                found = false;
                for (var i = 0; i < data.length; i++)
                {
                    entry = data[i];
                    found = true;
                    $("#tbody").append("<tr><td>" 
                    + entry.first_name + " " +  entry.last_name + "</td><td>"
                    + entry.headline + "</td><td>"
                    + '<a href="edit.php?profile_id=' + entry.profile_id + '">Edit</a></td></tr>');
                }
                if (!found)
                {
                    $("#tbody").append("<tr><td> no entries found </tr></td>\n");
                }
            }
            );
        </script>
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