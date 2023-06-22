<?php
    include_once "connection.php";

    if($_POST['bank']){
        $bank = $_POST['bank'];
        
        $sql = "INSERT INTO bank(bank_name) VALUES('$bank')";
        $result = mysqli_query($con, $sql);

}
header("Location: banks.php");
?>