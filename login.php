<?php 

    include 'basics/connection.php';
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (count($sfidTab->find('username', $username)) > 0 && ($sfidTab->find('username', $username))[0]->password == $password) {
        
        setcookie("username", $username, time() + 60 * 60 * 24 * 365);
        setcookie("password", $password, time() + 60 * 60 * 24 * 365);
        header('Location: /index.php');
    
    } else {
        header('Location: /loginPage.php');
    }
