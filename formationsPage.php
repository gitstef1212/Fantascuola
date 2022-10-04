<!DOCTYPE html>

<?php 
	include 'basics/connection.php';
?>

<script>

</script>

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
				<a class="index.php">Classifica</a>
				<a href="addPage.php">Aggiungi</a>
				<a href="thisPage">Formazioni</a>
				<a href="loginPage.php">Login</a>
				<a href="logout.php">Logout</a>
			</div>
		</header>
		<main>
			<div class="container">
				<p class="subtitle biggus">Formazioni</p>
            </div>
            <form class="container" action="/formation.php" method="post">
                <table>
                    <col width="<?= 100 / count($sfidanti) ?>%">
                    <col width="<?= 100 / count($sfidanti) ?>%">
                    <col width="<?= 100 / count($sfidanti) ?>%">
                    <thead>
                        <?php foreach ($sfidanti as $sfidante) : ?>
                            <th><?= $sfidante->nome ?></th>
                        <?php endforeach; ?>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < 4; $i ++) : ?>
                            <tr>
                                <?php foreach ($sfidanti as $key => $sfidante) : ?>
                                    <td>
                                        <select class="formazioni[<?= $sfidante->id ?>]" name="formazioni[<?= $sfidante->id?>][<?= $i ?>]">
                                            <?php foreach ($giocatoriPerSfidante[$sfidante->id] as $giocatore) : ?>
                                                <option value="<?= $giocatore->id ?>"><?= $giocatore->nome ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
                <div class="container margin-top center-flex">
                    <input type="submit" value="Salva">
                </div>
            </form>
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