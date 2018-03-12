<?php
    //DATABASE INFO
    include 'config/dbconfig.php';

    $pairs[] = [];

    $sql = "SELECT DISTINCT Function AS Functions FROM grds_data";
    //Add Function Category

    $result=mysqli_query($link, $sql);
    if (mysqli_num_rows($result) >= 1) {
        while($row = $result->fetch_array()){
            $functions[] = $row[0];
            $formattedfunctions[] = str_replace(" ", "_", $row[0]);
        }
    }
    $count = 0;
    foreach ($functions as $function) {
        if ($stmt = $link->prepare("SELECT DISTINCT Activity AS Activities FROM grds_data WHERE Function=?")) {
            $stmt->bind_param("s", $function);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) >= 1) {
                while($row = $result->fetch_array()){
                     $rows[] = $row[0];
                    //echo $function . " " . $row[0] . "\n";
                }
            }
            $pairs[$formattedfunctions[$count]] = $rows;
            unset($rows);
            $count++;
        }
    }
    echo json_encode($pairs);
    $link->close();
?>
