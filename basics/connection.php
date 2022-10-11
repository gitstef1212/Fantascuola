<?php 

    include "basics/DatabaseTable.php";

    $pdo = new \PDO('mysql:host=localhost;dbname=fantint', 'fantuser', 'fanta123');

    $sfidTab = new DatabaseTable($pdo, 'sfidanti', 'id');
    $critTab = new DatabaseTable($pdo, 'criteri', 'id');
    $giocTab = new DatabaseTable($pdo, 'giocatori', 'id');
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
    $punti = $puntiTab->findAll();
    $puntiLimitati = $puntiTab->findAll('id DESC', 42);

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
