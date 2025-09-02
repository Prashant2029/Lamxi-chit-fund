<?php

    session_start();    
    ini_set('display_errors', 0); // Disable error display
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL); // Log all errors for debugging


    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "banking";


    $conn = new mysqli($servername, $username, $password, $dbname);

    if(!$conn){
        echo("COnnection Faiiled");
    }
