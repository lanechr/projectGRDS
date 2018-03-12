<?php
    include 'config/dbconfig.php';
    $daid = $_REQUEST['daid'];

    // SQL Injection Protection
    $daid = stripslashes($daid);
    $daid = mysqli_real_escape_string($link, $daid);

    if ($stmt = $link->prepare("SELECT * FROM `grds_data` WHERE DAID=?")){
        $stmt->bind_param("s", $daid);
        $stmt->execute();
        $result=$stmt->get_result();

        if (mysqli_num_rows($result) == 0) {
            if ($stmt = $link->prepare("SELECT * FROM `Changes` WHERE OldDAID=?")){
                $stmt->bind_param("s", $daid);
                $stmt->execute();
                $result=$stmt->get_result();
                if (mysqli_num_rows($result) == 0) {
                    echo 1;
                }
            }
        }
    }

    $link->close();
?>