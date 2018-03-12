<?php 
//DATABASE INFO
include 'config/dbconfig.php';

$token = $_REQUEST['token'];

// SQL Injection Protection
$token = stripslashes($token);
$token = mysqli_real_escape_string($link, $token);

if ($stmt = $link->prepare("SELECT UserID, timeout, valid FROM password_reset WHERE user_token=?")) {
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result=$stmt->get_result();

    if (mysqli_num_rows($result) == 1) {
        //FOUND ENTRY
        while ($row = mysqli_fetch_row($result)) { 
            $userID = $row[0];
            $timeout = $row[1];
            $valid = $row[2];
        }
        if ((time() - $timeout) > 3600) {
            echo "TIMEOUT";
            exit;
        } else if ($valid != 1) {
            echo "INVALID";
            exit;
        } else {
            echo $userID;
            exit;
        }

    } else {
        //NO ENTRY FOUND
        echo "NOENTRY";
        exit;
    }
} else {
    //SQL Prepare failed
    echo "NOENTRY";
    exit;
}
$link->close();

?>