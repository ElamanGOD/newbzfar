<?php 
    // connecting database
    require "utils/bd.php";
    // destroying the session with user data
    session_destroy();
    // redirecting to main page
    header("Location: /index.php");
    die();
?>