<!DOCTYPE html>
<?php include 'basics/connection.php' ?>

<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="media/icon.jpg" type="image/ico" />
        <link rel="stylesheet" href="style/style.css">
		<title>Fantainterrogazioni 4H</title>
	</head>

	<body>
		<header>
            <div>
                <a href="index.php">Classifica</a>
                <a href="addPage.php">Aggiungi</a>
                <a class="thisPage">Login</a>
				<a href="logout.php">Logout</a>
            </div>
        </header>
		<main>
			<form class="container login" action="/login.php" method="post">
				<p class="subtitle">Login</p>
				<div>
					<span>Username</span>
					<input type="text" name="username">
				</div>
				<div>
					<span>Password</span>
					<input type="password" name="password">
				</div>
				<div>
					<input type="submit" value="Log In">
				</div>
			</form>
        </main>
	</body>
</html>