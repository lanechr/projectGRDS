<?php 
session_start();
//DATABASE INFO
include 'config/dbconfig.php';

//Uncomment for deployment
$userID = $_REQUEST['userID'];


// SQL Injection Protection
$userID = stripslashes($userID);
$userID = mysqli_real_escape_string($link, $userID);

if ($stmt = $link->prepare("SELECT email, UserType, FirstName, LastName, EmailNotify FROM Users WHERE UserID=?")){
    
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result=$stmt->get_result();

    if (mysqli_num_rows($result) == 1) {
        $hash=array();
        while ($row = mysqli_fetch_row($result)) { 
            $email=$row[0];
            $userType=$row[1];
            $fName=$row[2];
            $lName=$row[3];
            $notify=$row[4];
        }

       echo $email . "," . $userType . "," . $fName . "," . $lName . "," . $notify;

    } else {
        echo "1";
    }
} else {
    echo "1";
}

$link->close();

?>