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


if ($stmt = $link->prepare("SELECT UserID FROM Bookmarks WHERE UserID=? AND DAID=?")){
    $stmt->bind_param("ss", $userID, $daid);
    $stmt->execute();
    $result=$stmt->get_result();

    if (mysqli_num_rows($result) == 1) {
        //Bookmark Exists, delete bookmark
        if ($stmt = $link->prepare("DELETE FROM Bookmarks WHERE UserID=? AND DAID=?")){
            $stmt->bind_param("ss", $userID, $daid);
            if ($stmt->execute()) {
                echo "Deleted";
            } else {
                echo "Delete Error: " . mysqli_error($link);
            }
        } else {
            echo "Delete Error: " . mysqli_error($link);
        }
    } else {
        //Bookmark does not exist, add bookmark
        if ($stmt = $link->prepare("INSERT INTO Bookmarks (UserID, DAID, Notify)
            VALUES (?, ?, 1)")){
            $stmt->bind_param("ss", $userID, $daid);
            if ($stmt->execute()) {
                echo "Added";
            } else {
                echo "Add Error: " . mysqli_error($link);
            }
        } else {
            echo "Add Error: " . mysqli_error($link);
        }
    }
}

$link->close();

?>