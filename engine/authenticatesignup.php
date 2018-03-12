<?php 
session_start();
//DATABASE INFO
include 'config/dbconfig.php';

//Uncomment for deployment
$user_type = $_REQUEST['user_type'];
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$fname = $_REQUEST['fname'];
$lname = $_REQUEST['lname'];
$email_notify = 1;


// SQL Injection Protection
$user_type = stripslashes($user_type);
$user_type = mysqli_real_escape_string($link, $user_type);
$email = stripslashes($email);
$email = mysqli_real_escape_string($link, $email);
$fname = stripslashes($fname);
$fname = mysqli_real_escape_string($link, $fname);
$lname = stripslashes($lname);
$lname = mysqli_real_escape_string($link, $lname);
$hash = password_hash($password, PASSWORD_BCRYPT);

if ($stmt = $link->prepare("SELECT UserID FROM Users WHERE Email=?")){
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result=$stmt->get_result();

    if (mysqli_num_rows($result) == 1) {
        echo "1";
        //echo "User with this email already exists";	
    } else {
        if ($stmt = $link->prepare("INSERT INTO Users (UserType, FirstName, LastName, Email, Password, EmailNotify)
            VALUES (?, ?, ?, ?, ?, ?)")) {
            $stmt->bind_param("ssssss", $user_type, $fname, $lname, $email, $hash, $email_notify);
            
            if ($stmt->execute()) {
                if ($stmt = $link->prepare("SELECT UserID, UserType FROM Users WHERE Email=?")){
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result=$stmt->get_result();
                    if (mysqli_num_rows($result) == 1) {
                        while ($row = mysqli_fetch_row($result)) { 
                            $userID = $row[0];
                        }
                        $_SESSION['userID'] = $userID;
                        $_SESSION['userType'] = "Basic";
                    }

                    echo "Signup Successful";
                } else {
                    echo "FAIL";
                }
            } else {
                echo 2;
            }
        }


    }
} else {
    echo 2;
}

$link->close();

?>