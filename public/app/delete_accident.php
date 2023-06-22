<?php
    include_once "connection.php";

    $sql = "DELETE  FROM accident WHERE accident_id = '".$_GET['accident_id']."'";
    $res = mysqli_query($con, $sql);
    if($res) echo "done";
    else echo "not";
    header("Location: accidents.php");
?>