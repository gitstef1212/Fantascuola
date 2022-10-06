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
    foreach ($datas as $key => $sData) {

        $idGiocatore = $sData['giocatore'] ?? null;
        $evento = $sData['evento'] ?? null;
        
        if (!empty($sData['materia'])) $materia = intval($sData['materia']);
        
        if (empty($giocatore) || empty($evento)) continue;
        
        $idGiocatore = intval($idGiocatore);
        $evento = intval($evento);
        $volonario = $sData['volontario'] ?? false;

        $giocatore = $giocTab->findById($idGiocatore) ?? null;

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
            if ($giocatore) {
                $giocTab->update([
                    'id' => $idGiocatore,
                    'punti' => (($giocatore->punti ?? 0) + $puntiTotalizzati),
                    'ultimoVoto' => new DateTime()
                ]);
            }

            // Calcola Bonus Doppietta / Tripletta
            $votiOggiGioc = 0;
            $votiOggi = $puntiTab->find('data', date( 'Y-m-d', time()));
            foreach ($votiOggi as $vO) {
                if ($vO->giocatore == $giocatore->id && in_array($vO->evento[0], ['<', '6', '>'])) {
                    $votiOggiGioc += 1;
                }
            }

            // Calcola Bonus Doppietta / Tripletta
            if (in_array($siglaEvento[0], ['<', '6', '>']) && ($votiOggiGioc == 1 || $votiOggiGioc == 2)) {
                $puntiTotalizzati += ($votiOggiGioc == 1 ? $BONUS_DOPPIETTA : $BONUS_TRIPLETTA);
                $siglaEvento .= ($votiOggiGioc == 1 ? ' + D' : ' + T');
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
            
            // Aggiorna Punti Sfidante
            $sfidant = $sfidTab->findById($giocatore->proprietario) ?? null;
            if ($sfidant) {
                $sfidTab->update([
                    'id' => $sfidant->id,
                    'punti' => (($sfidant->punti ?? 0) + $puntiTotalizzati)
                ]);
            }

        }

    }

    header('Location: /addPage.php'); exit();
