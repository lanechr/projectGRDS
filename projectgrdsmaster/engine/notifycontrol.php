<?php 
//DATABASE INFO
include 'config/dbconfig.php';

$daid = $_REQUEST['daid'];
$userID = $_REQUEST['userID'];



// SQL Injection Protection
$userID = stripslashes($userID);
$userID = mysqli_real_escape_string($link, $userID);
$daid = stripslashes($daid);
$daid = mysqli_real_escape_string($link, $daid);


if ($stmt = $link->prepare("SELECT Notify FROM Bookmarks WHERE UserID=? AND DAID=?")){
    $stmt->bind_param("ss", $userID, $daid);
    $stmt->execute();
    $result=$stmt->get_result();

    if (mysqli_num_rows($result) == 1) {
        //Bookmark Exists, delete bookmark
        while ($row = mysqli_fetch_row($result)) { 
            $notify = $row[0];
        }
        if ($notify == 1){
            $notify = 0;
        } else {
            $notify = 1;
        }
        
        if ($stmt = $link->prepare("UPDATE `Bookmarks` SET `Notify`=? WHERE UserID=? AND DAID=?")){
            $stmt->bind_param("sss", $notify, $userID, $daid);
            
            if ($stmt->execute()) {
                if ($notify == 1){
                    echo "ON";
                } else {
                    echo "OFF";
                }
            } else {
                echo "ERROR";
            }
        }
    } else {
        //Bookmark does not exist, add bookmark
        echo "ERROR";
    }
}

$link->close();

?>