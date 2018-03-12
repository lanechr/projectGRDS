<?php
    include 'config/dbconfig.php';
    $olddaid = $_REQUEST['oldDaid'];
    $newdaid = $_REQUEST['newRecord'];
    $description = $_REQUEST['description'];
    $old_desc = $_REQUEST['oldDescription'];
    $func = $_REQUEST['funcVal'];
    $act = $_REQUEST['actVal'];
    $class = $_REQUEST['classVal'];
    $reason = $_REQUEST['reason'];
    $userID = $_REQUEST['userID'];
    $rtp = $_REQUEST['rtpVal'];

    // SQL Injection Protection
    $olddaid = stripslashes($olddaid);
    $olddaid = mysqli_real_escape_string($link, $olddaid);
    $newdaid = stripslashes($newdaid);
    $newdaid = mysqli_real_escape_string($link, $newdaid);
    $description = stripslashes($description);
    $description = mysqli_real_escape_string($link, $description);
    $old_desc = stripslashes($old_desc);
    $old_desc = mysqli_real_escape_string($link, $old_desc);
    $func = stripslashes($func);
    $func = mysqli_real_escape_string($link, $func);
    $act = stripslashes($act);
    $act = mysqli_real_escape_string($link, $act);
    $class = stripslashes($class);
    $class = mysqli_real_escape_string($link, $class);
    $reason = stripslashes($reason);
    $reason = mysqli_real_escape_string($link, $reason);
    $rtp = stripslashes($rtp);
    $rtp = mysqli_real_escape_string($link, $rtp);
    $userID = stripslashes($userID);
    $userID = mysqli_real_escape_string($link, $userID);

    if ($stmt = $link->prepare("SELECT * FROM `grds_data` WHERE DAID=?")){
        $stmt->bind_param("s", $olddaid);
        $stmt->execute();
        $result=$stmt->get_result();

        if (mysqli_num_rows($result) == 1) {
            while($row = $result->fetch_array()){
                $temp_daid = $row[0];
                $temp_author = $row[1];
                $temp_desc = $row[2];
                $temp_rtp = $row[3];
                $temp_func = $row[4];
                $temp_act = $row[5];
                $temp_class = $row[6];
                $temp_date = $row[7];
            }
        } else {
            echo "ERROR CANNOT FIND RECORD WITH DAID: " . $olddaid;
        }

        $result = "";

        if ($stmt = $link->prepare("UPDATE `grds_data` SET `DAID`=?, `AuthorID`=?, `Description`=?, `RTP`=?, `Function`=?, `Activity`=?, `Class`=? WHERE daid=?")){  
            $stmt->bind_param("ssssssss", $newdaid, $userID, $description, $rtp, $func, $act, $class, $olddaid);

            if ($stmt->execute()) {
                if ($stmt = $link->prepare("INSERT INTO `Changes` (`DAID`, `OldDAID`, `AuthorID`, `Description`, `RTP`, `Function`, `Activity`, `Reason`, `StartDate`) VALUES (?,?,?,?,?,?,?,?,?)")){
                    $stmt->bind_param("sssssssss", $newdaid, $olddaid, $userID, $old_desc, $temp_rtp, $temp_func, $temp_act, $reason, $temp_date);
                    if ($stmt->execute()) {
                        $sql = "SELECT LAST_INSERT_ID()";
                        $result=mysqli_query($link, $sql);
                        if (mysqli_num_rows($result) == 1) {
                            while($row = $result->fetch_array()){
                                $changeID = $row[0];
                            }
                            echo "Success," . $changeID;
                        } else {
                            echo "ERROR HERE";
                        }
                    } else {
                        //ERROR
                        echo $link->error;
                    }
                } else {
                    echo $link->error;
                }

            } else {
                echo "Error updating record: " . $link->error;
            }
        } else {
            echo "ERROR CANNOT FIND RECORD WITH DAID: " . $olddaid;
        }
    } else {
        echo "ERROR";
    }

    $link->close();
?>