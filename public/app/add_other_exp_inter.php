<?php 
    include_once "connection.php";

    $desc = mysqli_real_escape_string($con, trim($_POST['desc']));
    $total = mysqli_real_escape_string($con, trim($_POST['total']));

    if (!isset($_POST['LL'])) {
        $LL = "NULL";
    } else {
        $Lebanese = mysqli_real_escape_string($con, trim($_POST['LL']));
        if($Lebanese == ""){
            $LL = "NULL";
        }else{
            $LL = "'$Lebanese'";
        } 
    }

    $payday = mysqli_real_escape_string($con, trim($_POST['payday']));
    
    if (!isset($_POST['check_number'])) {
        $check_number = null;
    } else {
        $check_number = mysqli_real_escape_string($con, trim($_POST['check_number']));
    }
    if (!isset($_POST['check'])) {
        $check_date = null;
    } else {
        $check_date = mysqli_real_escape_string($con, trim($_POST['check']));
        //$check_date = "'$check'";
    }
    $bank = mysqli_real_escape_string($con, trim($_POST['bank']));

    if ($check_date == null || $check_date == "") {
        $query = "INSERT INTO other_expenses(description ,amount, lebanese_amount, payday, check_number, check_date, bank_id) 
        VALUES('$desc', '$total', $LL, '$payday', '$check_number', NULL, $bank)";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
    } else {
        $query = "INSERT INTO other_expenses(description ,amount, lebanese_amount, payday, check_number, check_date, bank_id) 
        VALUES('$desc', '$total', $LL, '$payday', '$check_number', '$check_date', $bank)";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
    }

 header("Location: other_expenses.php");
?>
