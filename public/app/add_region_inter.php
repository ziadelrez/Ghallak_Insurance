<?php
    include_once "connection.php";

    if ($_POST['region']) {
        $region = $_POST['region'];
        
        $sql = "INSERT INTO regions(name) VALUES('$region')";
        $result = mysqli_query($con, $sql);
    }
    header("Location: regions.php");
