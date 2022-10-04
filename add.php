<?php

    include 'basics/connection.php';

	$user = $sfidTab->find('username', $username);
	if ($user && $user[0]->password == $password) {
        $autore = $user[0]->id;
    } else {
        header('Location: /loginPage.php'); exit();
	}

    $datas = $_POST['data'] ?? [];

    $materia = 0;
    foreach ($datas as $sData) {
        $idGiocatore = $sData['giocatore'] ?? null;
        $evento = $sData['evento'] ?? null;
        
        if (!empty($sData['materia'])) $materia = intval($sData['materia']);
        
        if (empty($giocatore) || empty($evento)) continue;
        
        $idGiocatore = intval($idGiocatore);
        $evento = intval($evento);
        $volonario = $sData['volontario'] ?? false;

        if ($giocatore->attivo) {

            // Calcola Punti
            $evento = $critTab->findById($evento);
            $puntiTotalizzati = $evento->punti;
            $siglaEvento = $evento->sigla;
    
            // Volontario
            if ($volonario && in_array($evento->id, [1, 2, 3])) {
                $puntiTotalizzati++;
                $siglaEvento .= ' + V';
            }
    
            // Aggiorna Punti Giocatore
            $giocatore = $giocTab->findById($idGiocatore) ?? null;
            if ($giocatore) {
                $giocTab->update([
                    'id' => $idGiocatore,
                    'punti' => (($giocatore->punti ?? 0) + $puntiTotalizzati)
                ]);
            }
    
            // Aggiorna Punti
            $puntiTab->insert([
                'giocatore' => $idGiocatore,
                'sfidante' => $giocatore->proprietario,
                'evento' => $siglaEvento,
                'puntiii' => $puntiTotalizzati,
                'materia' => ($materia ?? null) == 0 ? null : $materia,
                'data' => new DateTime(),
                'autore' => $autore,
            ]);

        }

    }

    header('Location: /addPage.php'); exit();
