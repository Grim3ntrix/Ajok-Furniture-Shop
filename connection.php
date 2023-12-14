<?php
    $dbhost="localhost";
    $username="root";
    $password="";
    $dbname="ajokfurnitureshop";
    
    $conn = mysqli_connect($dbhost,$username,$password,$dbname);
    if (!$conn) {
        die ("Connection failed:".mysqli_connect_error());
    }

?>
