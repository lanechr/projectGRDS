<?php 
session_start();
//DATABASE INFO
include 'config/dbconfig.php';

//Uncomment for deployment
$email = $_REQUEST['email'];


// SQL Injection Protection
$email = stripslashes($email);
$email = mysqli_real_escape_string($link, $email);

if ($stmt = $link->prepare("SELECT UserID, UserType, FirstName, LastName FROM Users WHERE Email=?")){
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result=$stmt->get_result();

    if (mysqli_num_rows($result) == 1) {
        $hash=array();
        while ($row = mysqli_fetch_row($result)) { 
            $userID=$row[0];
            $userType=$row[1];
            $fName=$row[2];
            $lName=$row[3];
        }

       echo $userID . "," . $userType . "," . $fName . "," . $lName;

    } else {
        echo "1";
    }
} else {
    echo "1";
}

$link->close();

?>