<?php 
    include_once "connection.php";

    $accident_id = $_GET['accident_id'];
    $date =  mysqli_real_escape_string($con,trim($_POST['date']));
    $name =  mysqli_real_escape_string($con,trim($_POST['name']));
    $phone =  mysqli_real_escape_string($con,trim($_POST['phone']));
    $car =  mysqli_real_escape_string($con,trim($_POST['car']));
    $vin =  mysqli_real_escape_string($con,trim($_POST['vin']));
    $person =  mysqli_real_escape_string($con,trim($_POST['search2']));

    $sql1= "SELECT * FROM person WHERE person_name = '$person'";
    $res1 = mysqli_query($con, $sql1);
    $row = mysqli_fetch_array($res1);

    $sql = "UPDATE accident
            SET date = '$date', name = '$name', mobile = '$phone', car_number = '$car', car_vin = '$vin', person_id = '".$row['person_id']."'
            WHERE accident_id = '$accident_id'";
    $res = $res1 = mysqli_query($con, $sql) or die(mysqli_error($con));
    // echo "done";
    header("Location: accidents.php");
    ?>