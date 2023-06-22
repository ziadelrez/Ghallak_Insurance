<?php
    include_once "connection.php";

    $car_id = $_GET['car_id'];
    $person = $_GET['person_id'];
    $number =  mysqli_real_escape_string($con,trim($_POST['number']));
    $year =  mysqli_real_escape_string($con,trim($_POST['year']));
    $style =  mysqli_real_escape_string($con,trim($_POST['style']));
    $chassis =  mysqli_real_escape_string($con,trim($_POST['chassis']));
    $engine =  mysqli_real_escape_string($con,trim($_POST['engine']));
    $power =  mysqli_real_escape_string($con,trim($_POST['power']));
    $seats =  mysqli_real_escape_string($con,trim($_POST['seats']));
    $price =  mysqli_real_escape_string($con,trim($_POST['price']));
    $name =  mysqli_real_escape_string($con,trim($_POST['name']));
    $type =  mysqli_real_escape_string($con,trim($_POST['type']));
    
    $sql = "UPDATE car
            SET car_number = '$number',year =  '$year', style =  '$style', VIN = '$chassis' , engine_number =  '$engine', 
            engine_power = '$power' , seats = '$seats' , price = '$price' , car_name_id = '$name', car_type_id = '$type', person_id = '$person'
            WHERE car_id = '$car_id'";

    $res = mysqli_query($con, $sql);

    header("Location: person.php");
?>