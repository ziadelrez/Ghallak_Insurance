<?php 
    include_once "connection.php";

    $garage = mysqli_real_escape_string($con, trim($_POST['garage']));
    $accident = mysqli_real_escape_string($con, trim($_POST['accident_search']));
    $required_amount = mysqli_real_escape_string($con, trim($_POST['required_amount']));
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
    if ($bank == "0") {
        $bank1 = "NULL";
    } else $bank1 = "'$bank'";
    $accident_cost = mysqli_real_escape_string($con, trim($_POST['accident_cost']));

    $sql1 = "SELECT * FROM garage WHERE garage_name = '$garage'";
    $res1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_array($res1);

    if ($check_date == null || $check_date == "") {
        $query = "INSERT INTO garage_expenses(garage_id, accident_id, accident_cost_id, required_amount, lebanese_amount, date, check_number, check_date, bank_id) 
        VALUES('".$row1['garage_id']."', '$accident', '$accident_cost', '$required_amount', $LL, '$payday', '$check_number', NULL, $bank1)";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
    } else {
        $query = "INSERT INTO garage_expenses(garage_id, accident_id, accident_cost_id, required_amount, lebanese_amount, date, check_number, check_date, bank_id) 
        VALUES('".$row1['garage_id']."', '$accident', '$accident_cost', '$required_amount', $LL, '$payday', '$check_number', '$check_date', $bank1)";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
    }

    // if($result && $result2)
    //     echo "done";
    //     else echo "not";
 header("Location: garages_expenses.php");
?>