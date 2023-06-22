<?php
    include_once "connection.php";

    $sql = "DELETE  FROM company WHERE company_id = '".$_GET['company_id']."'";
    $res = mysqli_query($con, $sql);
    if($res) echo "done";
    else echo "not";
    header("Location: companies.php");
?>