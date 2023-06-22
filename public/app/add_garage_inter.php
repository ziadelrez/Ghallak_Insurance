<?php
    include_once "connection.php";

    if(isset($_POST['submit7'])){
        $garage = $_POST['garage'];
        $address = $_POST['address'];
        $mobile = $_POST['mobile'];
        $home = $_POST['home'];
        $owner = $_POST['owner'];

        $sql = "INSERT INTO garage(garage_name, location, mobile, home_number, owner_name) VALUES('$garage', '$address', '$mobile', '$home', '$owner')";
        $result = mysqli_query($con, $sql);

}
header("Location: garages.php");
?>