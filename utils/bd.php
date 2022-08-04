<?php
    // connecting redbeanphp ORM to with database    
    require 'assets/libs/rb.php';
    // filling data about server to variables
    $host = 'localhost';
    $dbname = 'bzfar';
    $username = 'root';
    $password = 'root';
    // setuping connection to database
    R::setup('mysql:host='.$host.';dbname='.$dbname,$username,$password);
    // checking if connection was established
    $isConnected = R::testConnection();
    if(!$isConnected)
    {
        echo "Sorry, there are some problems in connecting to database";
    }
    // starting session to contain user data
    session_start();
?>