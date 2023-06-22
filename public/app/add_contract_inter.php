<?php
    include_once "connection.php";

    $person = mysqli_real_escape_string($con, trim($_POST['search2']));
    $num =  mysqli_real_escape_string($con, trim($_POST['num']));
    $type =  mysqli_real_escape_string($con, trim($_POST['type']));
    $com =  mysqli_real_escape_string($con, trim($_POST['com']));
    $agent =  mysqli_real_escape_string($con, trim($_POST['agent']));
    
    $begin =  mysqli_real_escape_string($con, trim($_POST['begin']));
    $end =  mysqli_real_escape_string($con, trim($_POST['end']));
    
    if (!isset($_POST['price'])) {
        $price = "0.0";
    } else {
        $price =  mysqli_real_escape_string($con, trim($_POST['price']));
        if ($price == "") {
            $price = "0.0";
        }
    }
   
    if (!isset($_POST['office'])) {
        $office = "0.0";
    } else {
        $office =  mysqli_real_escape_string($con, trim($_POST['office']));
        if ($office == "") {
            $office = "0.0";
        }
    }
    
    if (!isset($_POST['agent_potion'])) {
        $agent_potion = "0.0";
    } else {
        $agent_potion =  mysqli_real_escape_string($con, trim($_POST['agent_potion']));
        if ($agent_potion == "") {
            $agent_potion = "0.0";
        }
    }
    $description =  mysqli_real_escape_string($con, trim($_POST['description']));
    $info =  mysqli_real_escape_string($con, trim($_POST['info']));
    //$car =  mysqli_real_escape_string($con,trim($_POST['car']));
    if (!isset($_POST['estate'])) {
        $estate = "0";
    } else {
        $estate =  mysqli_real_escape_string($con, trim($_POST['estate']));
        if ($estate == "") {
            $estate = "0";
        }
    }
    if (!isset($_POST['workers'])) {
        $workers = "0";
    } else {
        $workers =  mysqli_real_escape_string($con, trim($_POST['workers']));
        if ($workers == "") {
            $workers = "0";
        }
    }
    if (!isset($_POST['worker_salary'])) {
        $worker_salary = "0.0";
    } else {
        $worker_salary =  mysqli_real_escape_string($con, trim($_POST['worker_salary']));
        if ($worker_salary == "") {
            $worker_salary = "0.0";
        }
    }
    if (!isset($_POST['emp_salary'])) {
        $emp_salary = "0.0";
    } else {
        $emp_salary =  mysqli_real_escape_string($con, trim($_POST['emp_salary']));
        if ($emp_salary == "") {
            $emp_salary = "0.0";
        }
    }
    $degree =  mysqli_real_escape_string($con, trim($_POST['degree']));
    $value =  mysqli_real_escape_string($con, trim($_POST['value']));
    $maid =  mysqli_real_escape_string($con, trim($_POST['maid']));

    $sql1 = "SELECT * FROM person WHERE person_name = '$person'";
    $res1 = mysqli_query($con, $sql1);
    $row = mysqli_fetch_array($res1);

    if(!isset($_POST['car_search2']) || $_POST['car_search2'] == NULL){
        $car1 = 'NULL';
        
    }else{
        $car = mysqli_real_escape_string($con, trim($_POST['car_search2']));
    $ar = explode(" | ", $car);
    // echo $ar[1];

    $sql2 = "SELECT * FROM car WHERE car_number = '$ar[1]'";
    $res2 = mysqli_query($con, $sql2);
    $row2=mysqli_fetch_array($res2);
    $car1 = $row2['car_id'];
    // echo $ar[1];
    echo $car1;
    } 
    
    print_r($car1);
    
   // $finished = mysqli_real_escape_string($con,trim($_POST['finished']));
    if (!isset($_POST['finished'])) {
        $finish = "0";
    } else {
        $finish = "1";
    }

   
            $sql = "INSERT INTO contract(contract_number, company_id, person_id, start_date, end_date, price, office_portion, agent_portion, description, 
            info, car_id, real_estate_number, workers_number, worker_salary, employer_salary, injury_degree, value, housemaid_info, contract_type_id, agent, isFinished)
            VALUES('$num', '$com', '".$row['person_id']."', '$begin', '$end', '$price', '$office', '$agent_potion', '$description', '$info', $car1, '$estate',
            '$workers', '$worker_salary', '$emp_salary', '$degree', '$value', '$maid', '$type', '$agent', '$finish')";
            $res = mysqli_query($con, $sql) or die(mysqli_error($con));
            if ($res) {
                echo "done";
            } else {
                echo "not";
            }
  echo $sql;
    header("Location: contracts.php");
