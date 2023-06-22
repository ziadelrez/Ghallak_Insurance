<?php
    include_once "connection.php";

    $client_exp = $_GET['client_expenses_id'];
    $client =  mysqli_real_escape_string($con, trim($_POST['client']));
    $contract =  mysqli_real_escape_string($con, trim($_POST['contract']));
    $required_amount =  mysqli_real_escape_string($con, trim($_POST['required_amount']));
    if (!isset($_POST['LL'])) {
        $LL = "NULL";
    } else {
        $lebanese =  mysqli_real_escape_string($con, trim($_POST['LL']));
        if ($lebanese == "") {
            $LL = "NULL";
        } else {
            $LL = $lebanese;
        }
    }
   
    $payday =  mysqli_real_escape_string($con, trim($_POST['payday']));
    if (!isset($_POST['next_payday'])) {
        $next_payday = "NULL";
    } else {
        $next_payday1 = mysqli_real_escape_string($con, trim($_POST['next_payday']));
        if($next_payday1 == ""){
            $next_payday = "NULL";
        }else $next_payday = "'$next_payday1'";
    }
    $check_number =  mysqli_real_escape_string($con, trim($_POST['check_number']));
    
    $bank =  mysqli_real_escape_string($con, trim($_POST['bank']));
    if($bank == "0"){
        $bank1 = "NULL";
    }
    else $bank1 = "'$bank'";
    if (!isset($_POST['gift'])) {
        $gift = "0";
    } else {
        $gift = "1";
    }

    $sql1 = "SELECT * FROM person WHERE person_name = '$client'";
    $res1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_array($res1);
    
    // $sql2 = "SELECT * FROM contract WHERE contract_id = '$contract'";
    // $res2 = mysqli_query($con, $sql2);
    // $row2 = mysqli_fetch_array($res2);
    // $rest_price = $rest_amount - $required_amount;

    if (!isset($_POST['check'])) {
        $sql = "UPDATE client_expenses
            SET client_id = '".$row1['person_id']."', contract_id = '$contract', required_amount='$required_amount', 
            lebanese_amount = $LL, payday = '$payday', next_paydate = $next_payday, check_number = '$check_number',
            check_date = NULL, bank_id = $bank1, gift = '$gift'
            WHERE client_expenses_id = '$client_exp'";

        $result = mysqli_query($con, $sql) or die(mysqli_error(($con)));
    } else {
        $check = $_POST['check'];
        if ($check == null) {
            $sql = "UPDATE client_expenses
            SET client_id = '".$row1['person_id']."', contract_id = '$contract', required_amount='$required_amount', 
            lebanese_amount = $LL, payday = '$payday', next_paydate = $next_payday, check_number = '$check_number',
            check_date = NULL, bank_id = $bank1, gift = '$gift'
            WHERE client_expenses_id = '$client_exp'";

            $result = mysqli_query($con, $sql) or die(mysqli_error(($con)));
        } else {
            $sql = "UPDATE client_expenses
            SET client_id = '".$row1['person_id']."', contract_id = '$contract', required_amount='$required_amount', 
            lebanese_amount = $LL, payday = '$payday', next_paydate = $next_payday, check_number = '$check_number',
            check_date = '$check', bank_id = '$bank', gift = '$gift'
            WHERE client_expenses_id = '$client_exp'";

            $result = mysqli_query($con, $sql) or die(mysqli_error(($con)));
        }
    }
 
    // echo "done";
    header("Location: Clients_expenses.php");
