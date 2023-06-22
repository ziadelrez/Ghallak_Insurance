<?php
    include_once "connection.php";

    $person_id = $_GET['person_id'];
    $number =  mysqli_real_escape_string($con,trim($_POST['number']));
    
    if(!isset($_POST['year'])){
        $year = NULL;
    }else $year =  mysqli_real_escape_string($con,trim($_POST['year']));
    
    if(!isset($_POST['style'])){
        $style = NULL;
    }else $style =  mysqli_real_escape_string($con,trim($_POST['style']));
    
    if(!isset($_POST['chassis'])){
        $chassis = NULL;
    }else $chassis =  mysqli_real_escape_string($con,trim($_POST['chassis']));
    
    if(!isset($_POST['engine'])){
        $engine = NULL;
    }else $engine =  mysqli_real_escape_string($con,trim($_POST['engine']));
    
    if(!isset($_POST['power'])){
        $power = NULL;
    }else $power =  mysqli_real_escape_string($con,trim($_POST['power']));
    
    $seats =  mysqli_real_escape_string($con,trim($_POST['seats']));
    if($seats == NULL){
        $seats = 0;
    }
    
    $price =  mysqli_real_escape_string($con,trim($_POST['price']));
    if($price == NULL){
        $price = 0;
    }
    
    $name =  mysqli_real_escape_string($con,trim($_POST['name']));
    $type =  mysqli_real_escape_string($con,trim($_POST['type']));
    
    $sql = "INSERT INTO car(car_number, year, style, VIN, engine_number, engine_power, seats, price, car_name_id, car_type_id, person_id, id)
            VALUES('$number', '$year', '$style', '$chassis', '$engine', '$power', '$seats', '$price', '$name', '$type', '$person_id', NULL)";

    $res = mysqli_query($con, $sql);
    // if($res) echo "done";
    // else echo "no";

    header("Location: person.php");
?>