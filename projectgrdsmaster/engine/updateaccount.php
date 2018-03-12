<?php
    include 'config/dbconfig.php';
    $userID = $_REQUEST['userID'];
    $email = $_REQUEST['email'];
    $fname = $_REQUEST['fname'];
    $lname = $_REQUEST['lname'];

    // SQL Injection Protection
    $userID = stripslashes($userID);
    $userID = mysqli_real_escape_string($link, $userID);
    $email = stripslashes($email);
    $email = mysqli_real_escape_string($link, $email);
    $fname = stripslashes($fname);
    $fname = mysqli_real_escape_string($link, $fname);
    $lname = stripslashes($lname);
    $lname = mysqli_real_escape_string($link, $lname);

    if ($stmt = $link->prepare("UPDATE `Users` SET `Email`=?, FirstName=?, LastName=? WHERE UserID=?")){
        $stmt->bind_param("ssss", $email, $fname, $lname, $userID);
        if ($stmt->execute()) {
            echo "1";
        } else {
            echo "Update Error" . $link->error;
        }
    } else {
        echo 2;
    }

    $link->close();
?>