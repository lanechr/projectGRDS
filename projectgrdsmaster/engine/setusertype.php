<?php 
session_start();
//DATABASE INFO
include 'config/dbconfig.php';

//Uncomment for deployment
$userID = $_REQUEST['userID'];
$type = $_REQUEST['type'];

// SQL Injection Protection
$userID = stripslashes($userID);
$userID = mysqli_real_escape_string($link, $userID);
$type = stripslashes($type);
$type = mysqli_real_escape_string($link, $type);



if ($stmt = $link->prepare("UPDATE `Users` SET `UserType`=? WHERE UserID=?")){
    $stmt->bind_param("ss", $type, $userID);
    if ($stmt->execute()) {
        echo "1";
    } else {
        echo "Type Error: " . mysqli_error($link);
    }
}

$link->close();

?>