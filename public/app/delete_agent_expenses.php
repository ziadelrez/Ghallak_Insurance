<?php
    include_once "connection.php";

    $sql = "DELETE  FROM agent_expenses WHERE agent_expenses_id = '".$_GET['agent_expenses_id']."'";
    $res = mysqli_query($con, $sql);
    if($res) echo "done";
    else echo "not";
    header("Location: agents_expenses.php");
?>