<?php 

    include "DatabaseTable.php";

    $pdo = new PDO('mysql:host=localhost;dbname=fantint', 'fantuser', 'fanta123');
    
    $sfidTable = new DatabaseTable($pdo, 'sfidanti', 'id');
    
    