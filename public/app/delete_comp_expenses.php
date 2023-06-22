<?php
    include_once "connection.php";

    $sql = "DELETE  FROM companies_expenses WHERE companies_expenses_id = '".$_GET['comp_expenses_id']."'";
    $res = mysqli_query($con, $sql);
    if($res) echo "done";
    else echo "not";
    header("Location: companies_expenses.php");
?>