<?php
    include_once "connection.php";

    $sql = "DELETE  FROM client_expenses WHERE client_expenses_id = '".$_GET['client_expenses_id']."'";
    $res = mysqli_query($con, $sql);
    if($res) echo "done";
    else echo "not";
    header("Location: Clients_expenses.php");
?>