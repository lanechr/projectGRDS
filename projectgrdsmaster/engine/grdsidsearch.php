<?php
    include 'config/dbconfig.php';
    $daid = $_REQUEST['daid'];
    if ($daid == ""){
        //Request Error
        echo 1;
        exit;
    } else {
    
        //Protect from SQL Injection
        $daid = stripslashes($daid);
        $daid = mysqli_real_escape_string($link, $daid);

        if ($stmt = $link->prepare("SELECT * FROM `grds_data` WHERE daid=?")){  
            $stmt->bind_param("s", $daid);
            $stmt->execute();
            $result=$stmt->get_result();

            if (mysqli_num_rows($result) == 1) {
                while($row = $result->fetch_array()){
                  $rows[] = $row;
                  }
                echo json_encode($rows);
            } else {
                //DAID not found
                echo 2;
            }
        }
    }
    $link->close();
?>