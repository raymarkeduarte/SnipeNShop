<?php
    $dbhost = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $database = "online_shop";

    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $database);
    
    if($conn->connect_error) echo "Database Connection Error: " . $conn->connect_error;
?>