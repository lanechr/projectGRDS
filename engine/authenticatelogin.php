<?php 
session_start();
//DATABASE INFO
include 'config/dbconfig.php';

//Uncomment for deployment
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];

// SQL Injection Protection
$email = stripslashes($email);
$email = mysqli_real_escape_string($link, $email);

if ($stmt = $link->prepare("SELECT UserID, Password, UserType FROM Users WHERE Email=?")) {
$stmt->bind_param("s", $email);
$stmt->execute();
$result=$stmt->get_result();

if (mysqli_num_rows($result) == 1) {
    $hash=array();
    while ($row = mysqli_fetch_row($result)) { 
        $hash=$row[1];
        $userID = $row[0];
        $userType = $row[2];
    }
    
    if (password_verify($password, $hash)){
        $_SESSION['userID'] = $userID;
        $_SESSION['userType'] = $userType;
        echo "Success";
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