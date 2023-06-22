<?php
    include_once "connection.php";

    $sql = "DELETE  FROM other_expenses WHERE other_expenses_id = '".$_GET['other_expenses_id']."'";
    $res = mysqli_query($con, $sql);
    if($res) echo "done";
    else echo "not";
    header("Location: other_expenses.php");
?>