<?php
    include_once "connection.php";

    $date =  mysqli_real_escape_string($con,trim($_POST['date']));
    $name =  mysqli_real_escape_string($con,trim($_POST['name']));
    $phone =  mysqli_real_escape_string($con,trim($_POST['phone']));
    $car =  mysqli_real_escape_string($con,trim($_POST['car']));
    $vin =  mysqli_real_escape_string($con,trim($_POST['vin']));
    $person =  mysqli_real_escape_string($con,trim($_POST['search2']));

    $sql1= "SELECT * FROM person WHERE person_name = '$person'";
    $res1 = mysqli_query($con, $sql1);
    $row = mysqli_fetch_array($res1);

    $query = "INSERT INTO accident(date, name, mobile, car_number, car_vin,person_id) VALUES('$date', '$name', '$phone', '$car', '$vin', '".$row['person_id']."')";
    $ress = mysqli_query($con, $query) or die(mysqli_error($con));
 
    header("Location: accidents.php");
?>