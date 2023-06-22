<?php
    include_once "connection.php";

    $sql = "DELETE  FROM expert_expenses WHERE expert_expenses_id = '".$_GET['expert_expenses_id']."'";
    $res = mysqli_query($con, $sql);
    if($res) echo "done";
    else echo "not";
    header("Location: experts_expenses.php");
?>