<?php 
    $db= "grds_db";
    $host= "localhost";
    $dbuser= "php";
    $pw= "GRDSangels";

    $link = new mysqli($host, $dbuser, $pw, $db);
    if ($link->connect_errno) {
        echo 3;
    }

    mysqli_set_charset($link, "utf8");
?>