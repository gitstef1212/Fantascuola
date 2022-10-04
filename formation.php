<?php 

	include 'basics/connection.php';

    $formazioni = $_POST['formazioni'];
    
    foreach ($formazioni as $idSfidante => $formazione) {
        $sfidante = $sfidanti[$idSfidante];
        $idMembriScelti = array_unique(array_values($formazione));

        foreach ($giocatoriPerSfidante[$idSfidante] as $membroSquadra) {
            if (in_array($membroSquadra->id, $idMembriScelti)) {
                $giocTab->update([
                    'id' => $membroSquadra->id,
                    'attivo' => 1
                ]);
            } else {
                $giocTab->update([
                    'id' => $membroSquadra->id,
                    'attivo' => 0
                ]);
            }
        }

        header('Location: /index.php');
    }

