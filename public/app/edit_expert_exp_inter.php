<?php
include_once "connection.php";

$id = $_GET['expert_expenses_id'];
$expert = mysqli_real_escape_string($con, trim($_POST['expert']));
$accident = mysqli_real_escape_string($con, trim($_POST['accident']));
$required_amount = mysqli_real_escape_string($con, trim($_POST['required_amount']));
$accident_cost = mysqli_real_escape_string($con, trim($_POST['accident_cost']));
if (!isset($_POST['LL'])) {
    $LL = "NULL";
} else {
    $Lebanese = mysqli_real_escape_string($con, trim($_POST['LL']));
    if ($Lebanese == "") {
        $LL = "NULL";
    } else {
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
if ($bank == "0") {
    $bank1 = "NULL";
} else $bank1 = "'$bank'";

$sql1 = "SELECT * FROM person WHERE person_name = '$expert'";
$res1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_array($res1);

if ($check_date == null || $check_date == "") {
    $query = "UPDATE expert_expenses
                  SET expert_id = '" . $row1['person_id'] . "', accident_id = '$accident', accident_cost_id = '$accident_cost', required_amount = '$required_amount', 
                  lebanese_amount = $LL, date = '$payday', check_number = '$check_number', check_date = NULL, bank_id = $bank1
                   WHERE expert_expenses_id = '$id'";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
} else {
    $query = "UPDATE expert_expenses
        SET expert_id = '" . $row1['person_id'] . "', accident_id = '$accident',  accident_cost_id = '$accident_cost', required_amount = '$required_amount', 
        lebanese_amount = $LL, date = '$payday', check_number = '$check_number', check_date = '$check_date', bank_id = $bank1
         WHERE expert_expenses_id = '$id'";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
}

// if($result && $result2)
//     echo "done";
//     else echo "not";

header("Location: experts_expenses.php");
