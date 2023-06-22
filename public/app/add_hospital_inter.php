<?php
    include_once "connection.php";

    if($_POST['hosp']){
        $hosp = $_POST['hosp'];
        
        $sql = "INSERT INTO hospital(hospital_name) VALUES('$hosp')";
        $result = mysqli_query($con, $sql);

}
header("Location: hospitals.php");
?>