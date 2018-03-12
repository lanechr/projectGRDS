<?php
    include 'config/dbconfig.php';
    $userID = $_REQUEST['userID'];

    if ($userID == ""){
        //Request Error
        echo 1;
        exit;
    } else {
    
        //Protect from SQL Injection
        $userID = stripslashes($userID);
        $userID = mysqli_real_escape_string($link, $userID);
        
        //IMPROVED SEARCH ALGORITHM
        if ($stmt = $link->prepare("SELECT DAID FROM `Bookmarks` WHERE UserID=?")){
            $stmt->bind_param("s", $userID);
            $stmt->execute();
            $result=$stmt->get_result();
            if (mysqli_num_rows($result) >= 1) {
                while($daid = $result->fetch_array()){
                    $daids[] = $daid[0];
                }

                $sql  = "SELECT * FROM `grds_data` WHERE daid='$daids[0]'";

                $i = 1;

                while ($i < sizeof($daids)) {
                    $sql .= " OR daid='$daids[$i]'";
                    $i += 1;
                }

                //Get all entries

                $result=mysqli_query($link, $sql);

                if (mysqli_num_rows($result) >= 1) {
                    while($row = $result->fetch_array()){
                    $rows[] = $row;
                }
                echo json_encode($rows);

                }


            } else {
                //DAID not found
                echo 2;
            }
        } else {
            echo 2;
        }
    }
    $link->close();
?>
