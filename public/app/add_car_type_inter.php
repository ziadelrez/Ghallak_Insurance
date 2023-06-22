<?php
    include_once "connection.php";

    if($_POST['car_type']){
        $car_type = $_POST['car_type'];
        
        $sql = "INSERT INTO car_type(name) VALUES('$car_type')";
        $result = mysqli_query($con, $sql);

}
header("Location: cars_types.php");
?>