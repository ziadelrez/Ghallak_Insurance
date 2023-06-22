<?php
    include_once "connection.php";

        $id = $_GET['garage_id'];
        $garage = mysqli_real_escape_string($con,trim($_POST['garage']));
        $address = mysqli_real_escape_string($con,trim($_POST['address']));
        $mobile = mysqli_real_escape_string($con,trim($_POST['mobile']));
        $home = mysqli_real_escape_string($con,trim($_POST['home']));
        $owner = mysqli_real_escape_string($con,trim($_POST['owner']));

        $sql = "UPDATE garage
                SET garage_name = '$garage', location = '$address', mobile = '$mobile', home_number = '$home', owner_name = '$owner'
                WHERE garage_id = '$id'";
        $result = mysqli_query($con, $sql);
        
        header("Location: garages.php");

?>