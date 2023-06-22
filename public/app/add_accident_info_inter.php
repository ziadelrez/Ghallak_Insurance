<?php
    include_once "connection.php";

    $accident_id = $_GET['accident_id'];
    $cost =  mysqli_real_escape_string($con, trim($_POST['cost']));
    $date =  mysqli_real_escape_string($con, trim($_POST['date']));
    $afflicted =  mysqli_real_escape_string($con, trim($_POST['afflicted']));
    if ($afflicted == "") {
        $afflicted = null;
    }
    $info =  mysqli_real_escape_string($con, trim($_POST['info']));
    if ($info == "") {
        $info = null;
    }
    $contract =  mysqli_real_escape_string($con, trim($_POST['contract']));
    $car =  mysqli_real_escape_string($con, trim($_POST['car']));
    $expert =  mysqli_real_escape_string($con, trim($_POST['expert']));
    $garage =  mysqli_real_escape_string($con, trim($_POST['garage']));
    $hosp =  mysqli_real_escape_string($con, trim($_POST['hosp']));

    $sql1 = "SELECT * FROM accident WHERE accident_id = '$accident_id'";
    $res1 = mysqli_query($con, $sql1);
    $row = mysqli_fetch_array($res1);

    $sql = "SELECT * FROM car WHERE car_name_id = '$car' AND person_id = '".$row['person_id']."'";
    $res = mysqli_query($con, $sql);
    $row1 = mysqli_fetch_array($res);

    if($car == "0"){
        $car_id = "NULL";
    }
    else $car_id=$row1['car_id'];
    if($expert == "0"){
        $exp = "NULL";
    }
    else $exp = "'$expert'";
    if($hosp == "0"){
        $hosp1 = "NULL";
    }
    else $hosp1 = "'$hosp'";
    if($garage == "0"){
        $garage1 = "NULL";
    }
    else $garage1 = "'$garage'";

    if($date == null || $date == ""){
        $query = "INSERT INTO accident_cost(accident_id, cost, date, contract_id, car_id, afflicted, info, garage_id, hospital_id, expert_id, id)
            VALUES('$accident_id', '$cost', NULL, '$contract', $car_id, '$afflicted', '$info', $garage1, $hosp1, $exp, NULL)";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            //  if ($result) {
            //      echo "query done";
            //  } else {
            //      echo "query not done";
            //  }
    }
    else{
        $query = "INSERT INTO accident_cost(accident_id, cost, date, contract_id, car_id, afflicted, info, garage_id, hospital_id, expert_id, id)
            VALUES('$accident_id', '$cost', '$date', '$contract', $car_id, '$afflicted', '$info', $garage1, $hosp1, $exp, NULL)";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            //  if ($result) {
            //      echo "query done";
            //  } else {
            //      echo "query not done";
            //  }
    }
header("Location: edit_accident.php?accident_id=".$accident_id);