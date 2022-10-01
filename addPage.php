<!DOCTYPE html>
<?php include 'basics/connection.php' ?>

<!-- Login error = Empty Cookies -->

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
            </div>
        </header>
        <main>
			<div class="container">
				<p class="subtitle">Aggiungi Dati come <?= $username ?>...</p>
			</div>
			<div class="container">
				<table>
					<col width="30%">
					<col width="30%">
					<col width="30%">
					<col width="10%">
					<thead>
						<th>Materia</th>
						<th>Giocatore</th>
						<th>Evento</th>
						<th>V?</th>
					</thead>
					<tbody>
						<?php for ($i = 0; $i < 10; $i++) : ?>
							<tr>
								<td>
									<select name="data[<?=$i?>][materia]" onchange="checkItalics(this)" class="italics">
										<option disabled selected value="0" class="italics">Seleziona</option>
										<?php foreach ($materie as $materia) : ?>
											<option value="<?= $materia->id ?>" class="not-italics"><?= $materia->nome ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td></td>
								<td></td>
								<td><input type=checkbox name="data[<?=$i?>][volontario]" class="checkbox"></td>
							</tr>
						<?php endfor; ?>
					</tbody>
				</table>
			</d>
        </main>
	</body>
</html>

<!--
    Login Error = Back to Home

	Selezione
		Giocatore
		Fascia Voto

	La Materia si preserva fino a cambiamento
	
	Cosa genera LOG?
		Interrogato + Modificatore Voto
		Volontario
		Giustifica
		Infamata
		Doppietta / Tripletta (No Giocatore)
		Week's End (No Giocatore, No Materia)

	Cosa contiene il LOG?
		Punti
		[Tipo Evento]
		[Interrogato]
		[Materia]

	Ordine all'interno della Formazione
-->