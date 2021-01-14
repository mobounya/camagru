<!DOCTYPE html>
<html>
    <head>
        <title>This page is vulnerable</title>
    </head>
<body>
    <div id="container">
        <form method="POST">
            <input type="text" name="name">
        </form>
    <?php
        if (isset($_POST['name']))
        {
            echo $_POST['name'];
        }
    ?>
    </div>

</body>
</html>
