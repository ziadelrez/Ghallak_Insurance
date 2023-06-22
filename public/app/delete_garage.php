<?php
    include_once "connection.php";

    $sql = "DELETE  FROM garage WHERE garage_id = '".$_GET['garage_id']."'";
    $res = mysqli_query($con, $sql);
    if($res) echo "done";
    else echo "not";
    header("Location: garages.php");
?>