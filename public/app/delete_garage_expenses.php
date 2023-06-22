<?php
    include_once "connection.php";

    $sql = "DELETE  FROM garage_expenses WHERE garage_expenses_id = '".$_GET['garage_expenses_id']."'";
    $res = mysqli_query($con, $sql);
    if($res) echo "done";
    else echo "not";
    header("Location: garages_expenses.php");
?>