<?php 
    include_once "connection.php";

    $id = $_GET['other_expenses_id'];
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
        $query = "UPDATE other_expenses
                  SET description = '$desc', amount = '$total', lebanese_amount = $LL, payday = '$payday', check_number = '$check_number', 
                  check_date = NULL, bank_id = $bank
                   WHERE other_expenses_id = '$id'";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
    } else {
        $query = "UPDATE other_expenses
                  SET description = '$desc', amount = '$total', lebanese_amount = $LL, payday = '$payday', check_number = '$check_number', 
                  check_date = '$check_date', bank_id = $bank
                   WHERE other_expenses_id = '$id'";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
    }
   
header("Location: other_expenses.php");
?>