<?php 

    include "DatabaseTable.php";

    $pdo = new PDO('mysql:host=localhost;dbname=fantint', 'fantuser', 'fanta123');
    
    $sfidTab = new DatabaseTable($pdo, 'sfidanti', 'id');
    $critTab = new DatabaseTable($pdo, 'criteri', 'id');
    $partTab = new DatabaseTable($pdo, 'partecipanti', 'id');
    $votiTab = new DatabaseTable($pdo, 'voti', 'id');
    
    $sfidanti = $sfidTab->findAll();
    $criteri = $critTab->findAll();
    $partecipanti = $partTab->findAll();
    $voti = $votiTab->findAll();

    $classifica = [
        1 => $sfidanti[0],
        2 => $sfidanti[1],
        3 => $sfidanti[2]
    ];
    