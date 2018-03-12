<?php
    include 'config/dbconfig.php';
    $userID = $_REQUEST['userID'];

    // SQL Injection Protection
    $userID = stripslashes($userID);
    $userID = mysqli_real_escape_string($link, $userID);

    if ($stmt = $link->prepare("UPDATE `Users` SET `EmailNotify`='1' WHERE UserID=?")){
        $stmt->bind_param("s", $userID);
        if ($stmt->execute()) {
            echo "1";
        } else {
            echo "Unsubscribe Error" . $link->error;
        }
    }
    $link->close();
?>