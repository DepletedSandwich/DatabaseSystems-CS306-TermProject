<?php
    $servername="localhost";
    $usrname="root";
    $dbname="cs306_projectdb";

    $conn= new mysqli($servername,$usrname,"",$dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>