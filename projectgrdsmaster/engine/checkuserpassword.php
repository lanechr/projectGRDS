<?php 
session_start();
//DATABASE INFO
include 'config/dbconfig.php';

//Uncomment for deployment
$userID = $_REQUEST['userID'];
$password = $_REQUEST['password'];

// SQL Injection Protection
$userID = stripslashes($userID);
$userID = mysqli_real_escape_string($link, $userID);
$password = stripslashes($password);
$password = mysqli_real_escape_string($link, $password);

if ($stmt = $link->prepare("SELECT Password FROM Users WHERE UserID=?")) {
$stmt->bind_param("s", $userID);
$stmt->execute();
$result=$stmt->get_result();

if (mysqli_num_rows($result) == 1) {
    $hash=array();
    while ($row = mysqli_fetch_row($result)) { 
        $hash=$row[0];
    }
    
    if (password_verify($password, $hash)){
        echo 1;
    } else {
        echo "2";
    }
		
} else {
	echo "2";
}
} else {
    echo "2";
}

$link->close();

?>