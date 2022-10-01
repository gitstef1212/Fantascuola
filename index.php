<!DOCTYPE html>

<?php 
	include 'basics/connection.php';
    
	$classifica = [
        1 => $sfidanti[0],
        2 => $sfidanti[1],
        3 => $sfidanti[2]
    ];
?>

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
				<a class="thisPage">Classifica</a>
				<a href="addPage.php">Aggiungi</a>
				<a href="loginPage.php">Login</a>
			</div>
		</header>
		<main>
			<div class="container">
				<p class="subtitle">Classifica</p>
				<ol>
					<?php foreach ($classifica as $sfidante) : ?>
						<li></li>
					<?php endforeach; ?>
				</ol>
			</div>
			<div class="container">
				<p class="subtitle">Formazioni</p>
			</div>
			<div class="container">
				<p class="subtitle">Ultimi Dati</p>
			</div>
		</main>
	</body>
</html>