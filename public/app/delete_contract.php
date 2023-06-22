<?php
    include_once "connection.php";

    $sql = "DELETE  FROM contract WHERE contract_number = '".$_GET['contract_number']."'";
    $res = mysqli_query($con, $sql);
    if($res) echo "done";
    else echo "not";
    header("Location: contracts.php");
?>