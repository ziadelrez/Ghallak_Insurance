<?php
    include_once "connection.php";

$contract_number = $_GET['contract_number'];
$person = mysqli_real_escape_string($con,trim($_POST['search2']));
    $num =  mysqli_real_escape_string($con,trim($_POST['num']));
    $type =  mysqli_real_escape_string($con,trim($_POST['type']));
    $com =  mysqli_real_escape_string($con,trim($_POST['com']));
    $agent =  mysqli_real_escape_string($con,trim($_POST['agent']));
    
    $begin =  mysqli_real_escape_string($con,trim($_POST['begin']));
    $end =  mysqli_real_escape_string($con,trim($_POST['end']));
    
    if(!isset($_POST['price'])){
        $price = "0.0";
    }
    else{
        $price =  mysqli_real_escape_string($con,trim($_POST['price']));
        if ($price == "") {
            $price = "0.0";
        }
    } 
   
    if(!isset($_POST['office'])){
        $office = "0.0";
    }
    else {
        $office =  mysqli_real_escape_string($con,trim($_POST['office']));
        if ($office == "") {
            $office = "0.0";
        }
    }
    
    if(!isset($_POST['agent_potion'])){
        $agent_potion = "0.0";
    }
    else {
        $agent_potion =  mysqli_real_escape_string($con, trim($_POST['agent_potion']));
        if ($agent_potion == "") {
            $agent_potion = "0.0";
        }
    }
    $description =  mysqli_real_escape_string($con,trim($_POST['description']));
    $info =  mysqli_real_escape_string($con,trim($_POST['info']));
    //$car =  mysqli_real_escape_string($con,trim($_POST['car']));
    if(!isset($_POST['estate'])){
        $estate = "0";
    } 
    else {
        $estate =  mysqli_real_escape_string($con, trim($_POST['estate']));
        if ($estate == "") {
            $estate = "0";
        }
    }
    if(!isset($_POST['workers'])){
        $workers = "0";
    } 
    else {
        $workers =  mysqli_real_escape_string($con, trim($_POST['workers']));
        if ($workers == "") {
            $workers = "0";
        }
    }
    if(!isset($_POST['worker_salary'])){
        $worker_salary = "0.0";
    } 
    else {
        $worker_salary =  mysqli_real_escape_string($con, trim($_POST['worker_salary']));
        if ($worker_salary == "") {
            $worker_salary = "0.0";
        }
    }
    if(!isset($_POST['emp_salary'])){
        $emp_salary = "0.0";
    } 
    else {
        $emp_salary =  mysqli_real_escape_string($con, trim($_POST['emp_salary']));
        if ($emp_salary == "") {
            $emp_salary = "0.0";
        }
    }
    $degree =  mysqli_real_escape_string($con,trim($_POST['degree']));
    $value =  mysqli_real_escape_string($con,trim($_POST['value']));
    $maid =  mysqli_real_escape_string($con,trim($_POST['maid']));

    $sql1 = "SELECT * FROM person WHERE person_name = '$person'";
    $res1 = mysqli_query($con, $sql1);
    $row = mysqli_fetch_array($res1);

    $car = mysqli_real_escape_string($con,trim($_POST['car']));

    if(!isset($_POST['finished'])){
        $finish = "0";
    }
    else{
        $finish = "1";
    }
    if($car == "0"){
        $sql = "UPDATE contract
        SET company_id = '$com', person_id = '".$row['person_id']."', start_date = '$begin', end_date = '$end', price = '$price', office_portion = '$office',
        agent_portion = '$agent_potion', description = '$description', info = '$info', car_id = null, real_estate_number = '$estate',
        workers_number = '$workers', worker_salary = '$worker_salary', employer_salary = '$emp_salary', injury_degree = '$degree', 
        value = '$value', housemaid_info = '$maid', isFinished = '$finish'
        WHERE contract_number = '$contract_number'";
$res = mysqli_query($con, $sql) or die(mysqli_error($con));
if($res) echo "done";
else echo "not done";
    } else{
        $sql = "UPDATE contract
        SET company_id = '$com', person_id = '".$row['person_id']."', start_date = '$begin', end_date = '$end', price = '$price', office_portion = '$office',
        agent_portion = '$agent_potion', description = '$description', info = '$info', car_id = '$car', real_estate_number = '$estate',
        workers_number = '$workers', worker_salary = '$worker_salary', employer_salary = '$emp_salary', injury_degree = '$degree', 
        value = '$value', housemaid_info = '$maid', isFinished = '$finish'
        WHERE contract_number = '$contract_number'";
$res = mysqli_query($con, $sql) or die(mysqli_error($con));
if($res) echo "done";
else echo "not done";
    }
   header("Location: contracts.php");
