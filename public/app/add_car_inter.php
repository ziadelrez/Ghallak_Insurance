<?php
    include_once "connection.php";

    if($_POST['car']){
        $car = $_POST['car'];
        
        $sql = "INSERT INTO car_name(name) VALUES('$car')";
        $result = mysqli_query($con, $sql);

}
header("Location: cars.php");
?>