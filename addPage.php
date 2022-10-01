<!DOCTYPE html>

<?php 
	include 'basics/connection.php';

	$user = $sfidTab->find('username', $username);
	if (!$user || $user[0]->password != $password) {
		header('Location: /loginPage.php'); exit();
	}
?>

<script>
	function checkItalics(el) {
		el.classList.remove('italics');
	}
</script>

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
                <a class="thisPage">Aggiungi</a>
                <a href="loginPage.php">Login</a>
				<a href="logout.php">Logout</a>
            </div>
        </header>
        <main>
			<div class="container">
				<p class="subtitle">Aggiungi Dati come <?= $username ?>...</p>
			</div>
			<form class="container" action="/add.php" method="post">
				<table>
					<col width="30%">
					<col width="30%">
					<col width="30%">
					<col width="10%">
					<thead>
						<th>Materia</th>
						<th>Giocatore</th>
						<th>Evento</th>
						<th>V (+1)</th>
					</thead>
					<tbody>
						<?php for ($i = 0; $i < 10; $i++) : ?>
							<tr>
								<td>
									<select name="data[<?=$i?>][materia]" onchange="checkItalics(this)" class="italics">
										<option disabled selected value="0" class="italics">-------</option>
										<?php foreach ($materie as $materia) : ?>
											<option value="<?= $materia->id ?>" class="not-italics"><?= $materia->nome ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td>
									<select name="data[<?=$i?>][giocatore]" onchange="checkItalics(this)" class="italics">
										<option disabled selected value="0" class="italics">-------</option>
										<?php foreach ($giocatori as $giocatore) : ?>
											<option value="<?= $giocatore->id ?>" class="not-italics"><?= $giocatore->id . ") " .  $giocatore->nome ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td>
									<select name="data[<?=$i?>][evento]" onchange="checkItalics(this)" class="italics">
										<option disabled selected value="0" class="italics">-------</option>
										<?php foreach ($criteriSelezionabili as $indice => $nome) : ?>
											<option value="<?= $indice ?>" class="not-italics"><?= $nome ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td><input type=checkbox name="data[<?=$i?>][volontario]" class="checkbox"></td>
							</tr>
						<?php endfor; ?>
					</tbody>
				</table>
				<div class="submit-button-div container">
					<input type=submit class="submit-button" value="Salva"></input>
				</div>
			</form>
        </main>
	</body>
</html>