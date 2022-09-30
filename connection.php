<?php 

    include "DatabaseTable.php";

    $pdo = new PDO('mysql:host=localhost;dbname=test', 'fantuser', 'fanta123');
    
    $sfidTable = new DatabaseTable($pdo, 'sfidanti', 'id');
    print_r($sfidTable->findAll());
    