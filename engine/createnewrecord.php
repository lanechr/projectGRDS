<?php
    include 'config/dbconfig.php';
    $daid = $_REQUEST['daid'];
    $description = $_REQUEST['description'];
    $func = $_REQUEST['funcVal'];
    $act = $_REQUEST['actVal'];
    $class = $_REQUEST['classVal'];
    $userID = $_REQUEST['userID'];
    $rtp = $_REQUEST['rtpVal'];

    // SQL Injection Protection
    $daid = stripslashes($daid);
    $daid = mysqli_real_escape_string($link, $daid);
    $description = stripslashes($description);
    $description = mysqli_real_escape_string($link, $description);
    $func = stripslashes($func);
    $func = mysqli_real_escape_string($link, $func);
    $act = stripslashes($act);
    $act = mysqli_real_escape_string($link, $act);
    $class = stripslashes($class);
    $class = mysqli_real_escape_string($link, $class);
    $rtp = stripslashes($rtp);
    $rtp = mysqli_real_escape_string($link, $rtp);
    $userID = stripslashes($userID);
    $userID = mysqli_real_escape_string($link, $userID);

    if ($stmt = $link->prepare("INSERT INTO grds_data (DAID, AuthorID, Description, RTP, Function, Activity, Class)
            VALUES (?, ?, ?, ?, ?, ?, ?)")) {
            $stmt->bind_param("sssssss", $daid, $userID, $description, $rtp, $func, $act, $class);
            
            if ($stmt->execute()) {
                echo 1;
            }
    }

    $link->close();
?>