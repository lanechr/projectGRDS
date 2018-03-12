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
        while ($row = mysqli_fetch_row($result)) { 
            $notify = $row[0];
        }
        echo $notify;
    } else {
        echo "ERROR";
    }
} else {
    echo "ERROR";
}

$link->close();

?>