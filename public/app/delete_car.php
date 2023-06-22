<?php
    include_once "connection.php";

    $sql = "DELETE  FROM car WHERE car_id = '".$_GET['car']."'";
    $res = mysqli_query($con, $sql);
    if($res) echo "done";
    else echo "not";
    header("Location: cars.php");
?>