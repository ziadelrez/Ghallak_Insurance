<?php
    include_once "connection.php";

    $accident_cost_id = $_GET['accident_cost_id'];
    $cost =  mysqli_real_escape_string($con, trim($_POST['cost']));
    $date =  mysqli_real_escape_string($con, trim($_POST['date']));
    $afflicted =  mysqli_real_escape_string($con, trim($_POST['afflicted']));
    $info =  mysqli_real_escape_string($con, trim($_POST['info']));
    $contract =  mysqli_real_escape_string($con, trim($_POST['contract']));
    $car =  mysqli_real_escape_string($con, trim($_POST['car']));
    $expert =  mysqli_real_escape_string($con, trim($_POST['expert']));
    $garage =  mysqli_real_escape_string($con, trim($_POST['garage']));
    $hosp =  mysqli_real_escape_string($con, trim($_POST['hosp']));
    
    $sql2="SELECT * FROM accident_cost WHERE accident_cost_id='$accident_cost_id'";
    $res2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_array($res2);
    $sql1 = "SELECT * FROM accident WHERE accident_id = '".$row2['accident_id']."'";
    $res1 = mysqli_query($con, $sql1);
    $row = mysqli_fetch_array($res1);

    $sql = "SELECT * FROM car WHERE car_name_id = '$car' AND person_id = '".$row['person_id']."'";
    $res = mysqli_query($con, $sql);
    $row1 = mysqli_fetch_array($res);

    if($car == "0"){
        $car_id = "NULL";
    }
    else $car_id=$row1['car_id'];
if ($expert != "0" && $hosp != "0" && $garage != "0") {
    $query = "UPDATE accident_cost
                SET accident_id = '".$row2['accident_id']."', cost = '$cost', date = '$date', contract_id = '$contract', car_id = $car_id, afflicted = '$afflicted',
                info = '$info', garage_id = '$garage', hospital_id = '$hosp', expert_id = '$expert', id=NULL
                 WHERE accident_cost_id = '$accident_cost_id'";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
} else {
    if ($expert == "0" && $hosp == "0" && $garage == "0") {
        $query = "UPDATE accident_cost
                SET accident_id = '".$row2['accident_id']."', cost = '$cost', date = '$date', contract_id = '$contract', car_id = $car_id, afflicted = '$afflicted',
                 info = '$info',garage_id = NULL, hospital_id = NULL, expert_id = NULL, id=NULL
                 WHERE accident_cost_id = '$accident_cost_id'";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        if ($result) {
            echo "query done";
        } else {
            echo "query not done";
        }
    } else {
        if ($expert == "0" && $hosp == "0") {
            $query = "UPDATE accident_cost
                SET accident_id = '".$row2['accident_id']."', cost = '$cost', date = '$date', contract_id = '$contract', car_id = $car_id, afflicted = '$afflicted',
                 info = '$info',garage_id = '$garage', hospital_id = NULL, expert_id = NULL, id=NULL
                 WHERE accident_cost_id = '$accident_cost_id'";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            if ($result) {
                echo "query done";
            } else {
                echo "query not done";
            }
        } else {
            if ($expert == "0") {
                $query = "UPDATE accident_cost
                SET accident_id = '".$row2['accident_id']."', cost = '$cost', date = '$date', contract_id = '$contract', car_id = $car_id, afflicted = '$afflicted',
                 info = '$info',garage_id = '$garage', hospital_id = '$hosp', expert_id = NULL, id=NULL
                 WHERE accident_cost_id = '$accident_cost_id'";
                $result = mysqli_query($con, $query) or die(mysqli_error($con));
                if ($result) {
                    echo "query done";
                } else {
                    echo "query not done";
                }
            }
            if ($hosp == "0") {
                $query = "UPDATE accident_cost
                SET accident_id = '".$row2['accident_id']."', cost = '$cost', date = '$date', contract_id = '$contract', car_id = $car_id, afflicted = '$afflicted',
                 info = '$info',garage_id = '$garage', hospital_id = NULL, expert_id = '$expert', id=NULL
                 WHERE accident_cost_id = '$accident_cost_id'";
                $result = mysqli_query($con, $query) or die(mysqli_error($con));
                if ($result) {
                    echo "query done";
                } else {
                    echo "query not done";
                }
            }
        }
        if ($hosp == "0" && $garage == "0") {
            $query = "UPDATE accident_cost
                SET accident_id = '".$row2['accident_id']."', cost = '$cost', date = '$date', contract_id = '$contract', car_id = $car_id, afflicted = '$afflicted',
                 info = '$info',garage_id = NULL, hospital_id = NULL, expert_id = '$expert', id=NULL
                 WHERE accident_cost_id = '$accident_cost_id'";
            $result = mysqli_query($con, $query) ;
            if ($result) {
                echo "query done";
            } else {
                echo "query not done";
            }
        } else {
            if ($garage =="0") {
                $query = "UPDATE accident_cost
                SET accident_id = '".$row2['accident_id']."', cost = '$cost', date = '$date', contract_id = '$contract', car_id = $car_id, afflicted = '$afflicted',
                 info = '$info',garage_id = NULL, hospital_id = '$hosp', expert_id = '$expert', id=NULL
                 WHERE accident_cost_id = '$accident_cost_id'";
                $result = mysqli_query($con, $query) or die(mysqli_error($con));
                if ($result) {
                    echo "query done";
                } else {
                    echo "query not done";
                }
            }
        }
        if ($expert == "0" && $garage == "0") {
            $query = "UPDATE accident_cost
        SET accident_id = '".$row2['accident_id']."', cost = '$cost', date = '$date', contract_id = '$contract', car_id = $car_id, afflicted = '$afflicted',
         info = '$info',garage_id = NULL, hospital_id = '$hosp', expert_id = NULL, id=NULL
         WHERE accident_cost_id = '$accident_cost_id'";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            if ($result) {
                echo "query done";
            } else {
                echo "query not done";
            }
        }
    }
}

header("Location: edit_accident.php?accident_id=".$row2['accident_id']);
