<?php 

    include "basics/DatabaseTable.php";

    $pdo = new PDO('mysql:host=localhost;dbname=fantint', 'fantuser', 'fanta123');
    
    $sfidTab = new DatabaseTable($pdo, 'sfidanti', 'id');
    $critTab = new DatabaseTable($pdo, 'criteri', 'id');
    $giocTab = new DatabaseTable($pdo, 'giocatori', 'id');
    $puntiTab = new DatabaseTable($pdo, 'punti', 'id');
    $matTab = new DatabaseTable($pdo, 'materie', 'id');
    
    $sfidanti = $sfidTab->findAll();
    $criteri = $critTab->findAll();
    $giocatori = $giocTab->findAll();
    $punti = $puntiTab->findAll();
    $materie = $matTab->findAll();

    $username = $_COOKIE['username'] ?? null;
    $password = $_COOKIE['password'] ?? null;

    $criteriSelezionabili = [
        2 => ">= 8.5 (5)",
        1 => "6 ... 8.5 (3)",
        3 => "<= 6 (1)",
        4 => "GIUSTIFICA (-3)",
        8 => "INFAMATA (-5)"
    ];

    $nomiSfidanti = [];
    // $sfidantiOrdinati = [];
    foreach ($sfidanti as $sfidante) {
        $nomiSfidanti[$sfidante->id] = $sfidante->nome;
    }
    
    foreach ($giocatori as $key => $giocatore) {
        if (in_array($giocatore->nome, $nomiSfidanti)) {
            // $sfidantiOrdinati[$giocatore->id] = $giocatore;
            unset($giocatori[$key]);
        }
    }

    $puntiLimitati = $puntiTab->findAll('id DESC', 42);

    $giocatoriPerSfidante = [];
    foreach ($sfidanti as $key => $sfidante) {
        $giocatoriPerSfidante[$sfidante->id] = [];
    }

    foreach ($giocatori as $key => $giocatore) {
        $giocatoriPerSfidante[$giocatore->proprietario][] = $giocatore;
    }
    