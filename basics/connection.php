<?php 

    include "basics/DatabaseTable.php";

    $pdo = new \PDO('mysql:host=localhost;dbname=fantint', 'fantuser', 'fanta123');

    $sfidTab = new DatabaseTable($pdo, 'sfidanti', 'id');
    $critTab = new DatabaseTable($pdo, 'criteri', 'id');
    $giocTab = new DatabaseTable($pdo, 'giocatori', 'id');
    $puntiSettTab = new DatabaseTable($pdo, 'puntiSettimana', 'id');
    $puntiTab = new DatabaseTable($pdo, 'punti', 'id');
    $matTab = new DatabaseTable($pdo, 'materie', 'id');

    // Credenziali
    $username = $_COOKIE['username'] ?? null;
    $password = $_COOKIE['password'] ?? null;

    // Criteri
    $criteri = $critTab->findAll();
    $criteriSelezionabili = [
        2 => ">= 8.5 (5)",
        1 => "6 ... 8.5 (3)",
        3 => "<= 6 (1)",
        4 => "GIUSTIFICA (-3)",
        8 => "INFAMATA (-5)"
    ];

    $BONUS_DOPPIETTA = 5;
    $BONUS_TRIPLETTA = 7 - $BONUS_DOPPIETTA;

    // Materie
    $materie = $matTab->findAll();

    // Punti Settimanali => Punti
    $rawSfidanti = $sfidTab->findAll('puntiSettimana DESC');
    if (strtotime("now") >= strtotime($rawSfidanti[0]->dataConversione) + 604800) {
        
        $puntiMaggiori = $rawSfidanti[0]->puntiSettimana;
        $puntiAggiunti = 3;

        print_r($sfidanti);
        foreach ($rawSfidanti as $rawSfidante) {
            if ($rawSfidante->puntiSettimana < $puntiMaggiori) {
                $puntiMaggiori = $rawSfidante->puntiSettimana;

                if ($puntiAggiunti == 3) {
                    $puntiAggiunti = 2;
                } else {
                    $puntiAggiunti = 0;
                }
            }

            // echo ' || ' . $rawSfidante->puntiSettimana . ' ' . $puntiMaggiori . ' ' . $puntiAggiunti;
            
            $puntiTab->insert([
                'sfidante' => $rawSfidante->id,
                'puntiiiii' => $puntiAggiunti,
                'data' => date('Y/m/d', strtotime("this week"))
            ]);

            $sfidTab->update([
                'id' => $rawSfidante->id,
                'punti' => ($rawSfidante->punti ?? 0) + $puntiAggiunti,
                'puntiSettimana' => 0,
                'dataConversione' => date('Y/m/d', strtotime("this week"))
            ]);
        }
    } 
    
    // Sfidanti
    $rawSfidanti = $sfidTab->findAll();
    $sfidanti = [];
    foreach ($rawSfidanti as $key => $rawSfidante) {
        $sfidanti[$rawSfidante->id] = $rawSfidante;
    }

    // Nomi Sfidanti
    $nomiSfidanti = [];
    foreach ($sfidanti as $sfidante) {
        $nomiSfidanti[$sfidante->id] = $sfidante->nome;
    }

    // Nomi Sfidanti Nomi
    $nomiSfidantiNomi = [];
    foreach (array_values($nomiSfidanti) as $nomeSfidante) {
        $nomiSfidantiNomi[] = explode(" ", $nomeSfidante)[0];
    }

    // Classifica
    $classifica = $sfidTab->findAll('punti DESC');

    // Punti
    $puntiLimitati = $puntiSettTab->findAll('id DESC', 42);

    // Giocatori
    $rawGiocatori = $giocTab->findAll();
    foreach ($rawGiocatori as $key => $rawGiocatore) {
        if (!(in_array($rawGiocatore->nome, $nomiSfidanti))) {
            $giocatori[$rawGiocatore->id] = $rawGiocatore;
        }
    }

    // Giocatori Per Sfidante
    $giocatoriPerSfidante = [];
    foreach ($sfidanti as $id => $sfidante) {
        $giocatoriPerSfidante[$id] = [];
    }

    foreach ($giocatori as $key => $giocatore) {
        $giocatoriPerSfidante[$giocatore->proprietario][] = $giocatore;
    }
