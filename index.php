<!DOCTYPE html>

<?php 
	include 'basics/connection.php';
    
	$classifica = [
        1 => $sfidanti[1],
        2 => $sfidanti[2],
        3 => $sfidanti[3]
    ];
?>

<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="media/icon.jpg" type="image/ico" />
		<link rel="stylesheet" href="style/style.css">
		<title>Fanta Interrogazioni 4H</title>
	</head>

	<body>
		<header>
			<div>
				<a class="thisPage">Classifica</a>
				<a href="addPage.php">Aggiungi</a>
				<a href="formationsPage.php">Formazioni</a>
				<a href="loginPage.php">Login</a>
				<a href="logout.php">Logout</a>
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
				<table class="formations-home-table">
					<?php for ($i = 0; $i < count($sfidanti); $i++) : ?>
						<col width="<?= 100 / count($sfidanti) ?>%">
					<?php endfor;?>

					<thead>
						<tr>
							<?php foreach ($sfidanti as $sfidante) : ?>
								<th><?= $sfidante->nome ?></th>
							<?php endforeach; ?>
						</tr>
					</thead>

					<tbody>
						<?php for ($i = 0; $i < (count($giocatori) / count ($sfidanti)); $i ++) : ?>
							<tr>
								<?php foreach ($sfidanti as $idSfid => $sfidante) : ?>
									<?php $gio = $giocatoriPerSfidante[$idSfid][$i]; ?>
									<td class="bold <?= $gio->attivo ? 'giocAttivo' : 'giocPanchina' ?>"><?= $gio->nome ?></td>
								<?php endforeach; ?>
							</tr>
						<?php endfor; ?>
					</tbody>
				</table>
			</div>
			<div class="container">
				<p class="subtitle">Ultimi Dati</p>
				<table class="last42">
					<col width="15%">
					<col width="10%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="15%">

					<thead>
						<th>Sfidante</th>
						<th>Punti</th>
						<th>Dettagli</th>
						<th>Giocatore</th>
						<th>Materia</th>
						<th>Data</th>
						<th>Autore</th>
					</thead>
					<tbody>
						<?php foreach ($puntiLimitati as $punto) : ?>
							<tr>
								<td><?= explode(" ", $nomiSfidanti[$punto->sfidante])[0] ?></td>
								<td><?= $punto->puntiii ?></td>
								<td><?= $punto->evento ?></td>
								<td><?= $giocatori[$punto->giocatore]->nome?></td>
								<td><?= empty($punto->materia) ? '---' : $materie[$punto->materia - 1]->nome ?></td>
								<td><?= implode("/", array_reverse(explode("-", $punto->data))) ?></td>
								<td><?= explode(" ", $nomiSfidanti[$punto->autore])[0] ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</main>
	</body>
</html>

<!--

	Cosa genera LOG?
		Interrogato + Modificatore Voto
		Volontario
		Giustifica
		Infamata
		Doppietta / Tripletta (No Giocatore)
		Week's End (No Giocatore, No Materia)

	Cosa contiene il LOG?
		Sfidante
		Punti
		Tipo Evento
		[Giocatore]
		[Materia]
		Data
		Autore

	Ordine all'interno della Formazione
-->