<?php
	session_start();
	require_once("./config/setup.php");
	$query = "SELECT * FROM gallery";
	$stmt = $pdo->prepare($query);
	$stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
	<title>Gallery</title>
</head>
<body>
    <div class="ft_navbar">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="app.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="index.php">Gallery</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
	<div style="top: 25px; position: relative; display: inline-block" class="border border-5">
		<div class="card-header">
		<i class="bi bi-caret-right-fill"></i>
			mobounya
		</div>
		<?php
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$src = $row["image"];
			echo "<img class=\"img-fluid\" src=\"{$src}\"><br>";
		?>
		<i style="margin-left: 5px;" class="bi bi-suit-heart"> 12</i>
		<h6 style="margin-top: 6px; margin-left: 5px;">Comments</h6>
		<div class="comment card">
			<div class="card-body">
				This what a comment will look like.
			</div>
		</div>
		<div class="comment card">
			<div class="card-body">
				This what a second comment will look like.
			</div>
		</div>
		<div id="insertcomment">
			<h6 style="margin-top: 30px">Insert Comment</h6>
			<div class="form-group">
				<textarea class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
  			</div>
		</div>
	</div>
</body>
</html>