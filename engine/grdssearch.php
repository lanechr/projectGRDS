<?php
    include 'config/dbconfig.php';
    $keywords = $_REQUEST['keywords'];
    $function = $_REQUEST['functionStr'];
    $activity = $_REQUEST['activity'];

    if ($keywords == ""){
        //Request Error
        echo 1;
        exit;
    } else {
    
        //Protect from SQL Injection
        $keywords = stripslashes($keywords);
        $keywords = mysqli_real_escape_string($link, $keywords);
        $function = stripslashes($function);
        $function = mysqli_real_escape_string($link, $function);
        $activity = stripslashes($activity);
        $activity = mysqli_real_escape_string($link, $activity);
        
        $keywords = str_replace(" ", "* +", $keywords);
        $keywords = "+" . $keywords . "*";
        
        $sql  = "SELECT * FROM `grds_data` WHERE MATCH(Description) AGAINST(? IN BOOLEAN MODE)";
        //Add Function Category
        if ($function != "") {
            $sql = $sql . " AND function=?";
            if ($activity != "") {
                $sql = $sql . " AND activity=?";
            }
        }
        
        if ($stmt = $link->prepare($sql)){
            if ($function != "") {
                if ($activity != "") {
                    $stmt->bind_param("sss", $keywords, $function, $activity);
                } else {
                    $stmt->bind_param("ss", $keywords, $function);
                }
            } else {
                $stmt->bind_param("s", $keywords);
            }
        
            $stmt->execute();

            $result=$stmt->get_result();
            if (mysqli_num_rows($result) >= 1) {
                while($row = $result->fetch_array()){
                    $rows[] = $row;
                }
                echo json_encode($rows);
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
