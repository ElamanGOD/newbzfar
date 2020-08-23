<?php    
    require 'assets/libs/rb.php';

    $host = 'localhost';
    $dbname = 'bzfar';
    $username = 'root';
    $password = 'root';

    R::setup('mysql:host='.$host.';dbname='.$dbname,$username,$password);

    $testconnection = R::testConnection();

    session_start();
?>