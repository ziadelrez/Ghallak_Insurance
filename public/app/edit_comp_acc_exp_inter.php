<?php
include_once "connection.php";
$id = $_GET['comp_acc_exp_id'];
$company = mysqli_real_escape_string($con, trim($_POST['company']));
$accident = mysqli_real_escape_string($con, trim($_POST['accident']));
$accident_cost = mysqli_real_escape_string($con, trim($_POST['accident_cost']));
$required_amount = mysqli_real_escape_string($con, trim($_POST['required_amount']));
if (!isset($_POST['LL'])) {
    $LL = "NULL";
} else {
    $Lebanese = mysqli_real_escape_string($con, trim($_POST['LL']));
    if($Lebanese == ""){
        $LL = "NULL";
    }
    else $LL = "'$Lebanese'";
    
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
if($bank == "0"){
    $bank1 = "NULL";
}
else $bank1 = "'$bank'";

$sql1 = "SELECT * FROM company WHERE company_name = '$company'";
$res1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_array($res1);


if ($check_date == null || $check_date == "") {
    $query = "UPDATE companies_accident_expenses
                SET company_id = '" . $row1['company_id'] . "', accident_id = '$accident', accident_cost_id = '$accident_cost', required_amount = '$required_amount',
                 lebanese_amount = $LL, date = '$payday', check_number = '$check_number', check_date = NULL, bank_id = $bank1
                WHERE companies_accident_expenses_id = '$id'";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
} else {
    $query = "UPDATE companies_accident_expenses
                SET company_id = '" . $row1['company_id'] . "', accident_id = '$accident', accident_cost_id = '$accident_cost', required_amount = '$required_amount',
                 lebanese_amount = $LL, date = '$payday', check_number = '$check_number', check_date = '$check_date', bank_id = $bank1
                WHERE companies_accident_expenses_id = '$id'";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
}

header("Location: companies_expenses.php");
