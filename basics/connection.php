<?php 

    include "basics/DatabaseTable.php";

    $pdo = new PDO('mysql:host=localhost;dbname=fantint', 'fantuser', 'fanta123');
    
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

    // Materie
    $materie = $matTab->findAll();

    // Sfidanti
    $rawSfidanti = $sfidTab->findAll();
    $sfidanti = [];
    foreach ($rawSfidanti as $key => $rawSfidante) {
        $sfidanti[$rawSfidante->id] = $rawSfidante;
    }

    $nomiSfidanti = [];
    foreach ($sfidanti as $sfidante) {
        $nomiSfidanti[$sfidante->id] = $sfidante->nome;
    }

    // Punti
    $punti = $puntiTab->findAll();
    $puntiLimitati = $puntiTab->findAll('id DESC', 42);

    // Giocatori
    $giocatori = $giocTab->findAll();
    foreach ($giocatori as $key => $giocatore) {
        if (in_array($giocatore->nome, $nomiSfidanti)) {
            unset($giocatori[$key]);
        }
    }

    // Giocatori Per Sfidante
    $giocatoriPerSfidante = [];
    foreach ($sfidanti as $key => $sfidante) {
        $giocatoriPerSfidante[$sfidante->id] = [];
    }

    foreach ($giocatori as $key => $giocatore) {
        $giocatoriPerSfidante[$giocatore->proprietario][] = $giocatore;
    }
