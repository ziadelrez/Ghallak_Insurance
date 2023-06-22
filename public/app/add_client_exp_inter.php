<?php
include_once "connection.php";

$client = mysqli_real_escape_string($con, trim($_POST['client']));
$total = mysqli_real_escape_string($con, trim($_POST['total']));
$contract = mysqli_real_escape_string($con, trim($_POST['contract_search']));
$required_amount =  mysqli_real_escape_string($con, trim($_POST['required_amount']));

if (!isset($_POST['LL'])) {
    $LL = "NULL";
} else {
    $Lebanese = mysqli_real_escape_string($con, trim($_POST['LL']));
    if ($Lebanese == "") {
        $LL = "NULL";
    } else $LL = "'$Lebanese'";
}

if (!isset($_POST['payday'])) {
    $payday = null;
} else {
    $payday = mysqli_real_escape_string($con, trim($_POST['payday']));
    //$payday = "'$payday1'";
}

if (!isset($_POST['next_payday'])) {
    $next_payday = "NULL";
} else {
    $next_payday1 = mysqli_real_escape_string($con, trim($_POST['next_payday']));
    if($next_payday1 == ""){
        $next_payday = "NULL";
    }else $next_payday = "'$next_payday1'";
}

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
if ($bank == "0") {
    $bank1 = "NULL";
} else $bank1 = "'$bank'";
if (!isset($_POST['gift'])) {
    $gift = "0";
} else {
    $gift = "1";
}

// $rest_amount = mysqli_real_escape_string($con, trim($_POST['rest_amount']));
// $total_amount = $total - $required_amount;

//echo $rest_amount;
$sql1 = "SELECT * FROM person WHERE person_name = '$client'";
$res1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_array($res1);

$sql2 = "SELECT * FROM contract WHERE contract_number = '$contract'";
$res2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_array($res2);
// $rest_price = $rest_amount - $required_amount;

// $query1 = "UPDATE contract 
//                 SET price = '$rest_price'
//                 WHERE contract_id = '$contract'";
// $result2 = mysqli_query($con, $query1);


if ($check_date == null) {
    $query = "INSERT INTO client_expenses(client_id, contract_id, required_amount, lebanese_amount, payday, next_paydate, check_number, 
            check_date, bank_id, gift) VALUES('" . $row1['person_id'] . "', '".$row2['contract_id']."', '$required_amount', $LL, '$payday', $next_payday,
             '$check_number', NULL, $bank1, $gift )";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
} else {
    $query = "INSERT INTO client_expenses(client_id, contract_id, required_amount, lebanese_amount, payday, next_paydate, check_number,
         check_date, bank_id, gift) VALUES('" . $row1['person_id'] . "', '".$row2['contract_id']."', '$required_amount', $LL, '$payday', $next_payday,
           '$check_number', '$check_date', $bank1, $gift )";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
}


header("Location: Clients_expenses.php");
