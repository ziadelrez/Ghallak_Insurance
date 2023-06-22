<?php
    include_once "connection.php";

    $sql = "DELETE  FROM accident_cost WHERE accident_cost_id = '".$_GET['accident_cost_id']."'";
    $res = mysqli_query($con, $sql);
    if($res) echo "done";
    else echo "not";
    header("Location: accidents.php");
?>