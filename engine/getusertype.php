<?php 
session_start();
//DATABASE INFO
include 'config/dbconfig.php';

//Uncomment for deployment
$userID = $_REQUEST['userID'];

//Debugging Code
//$email = "test2@test.com";
//$password = "Password";

// SQL Injection Protection
$userID = stripslashes($userID);
$userID = mysqli_real_escape_string($link, $userID);

if ($stmt = $link->prepare("SELECT UserType FROM Users WHERE UserID=?")){
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result=$stmt->get_result();

    if (mysqli_num_rows($result) == 1) {
        $hash=array();
        while ($row = mysqli_fetch_row($result)) { 
            $user=$row[0];
        }

       if ($user != "") {
            echo $user;
        } else {
            echo "2";
        }

    } else {
        echo "1";
    }
} else {
    echo "1";
}

$link->close();

?>