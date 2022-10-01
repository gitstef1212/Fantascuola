<?php 

    include "basics/DatabaseTable.php";

    $pdo = new PDO('mysql:host=localhost;dbname=fantint', 'fantuser', 'fanta123');
    
    $sfidTab = new DatabaseTable($pdo, 'sfidanti', 'id');
    $critTab = new DatabaseTable($pdo, 'criteri', 'id');
    $partTab = new DatabaseTable($pdo, 'partecipanti', 'id');
    $votiTab = new DatabaseTable($pdo, 'voti', 'id');
    $matTab = new DatabaseTable($pdo, 'materie', 'id');
    
    $sfidanti = $sfidTab->findAll();
    $criteri = $critTab->findAll();
    $partecipanti = $partTab->findAll();
    $voti = $votiTab->findAll();
    $materie = $matTab->findAll();

    $username = $_COOKIE['username'] ?? null;
    $password = $_COOKIE['password'] ?? null;
