<?php 
//DATABASE INFO
include 'config/dbconfig.php';

$userID = $_REQUEST['userID'];
$pword = $_REQUEST['pword'];

// SQL Injection Protection
$pword = stripslashes($pword);
$pword = mysqli_real_escape_string($link, $pword);
$userID = stripslashes($userID);
$userID = mysqli_real_escape_string($link, $userID);
$hash = password_hash($pword, PASSWORD_BCRYPT);

if ($stmt = $link->prepare("UPDATE `Users` SET `Password`=? WHERE UserID=?")){
    $stmt->bind_param("ss", $hash, $userID);
    if ($stmt->execute()) {
        echo "1";
    } else {
        echo "Reset Error: " . mysqli_error($link);
    }
}
$link->close();

?>