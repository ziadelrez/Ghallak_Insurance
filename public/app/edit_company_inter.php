<?php
    include_once "connection.php";

        $id = $_GET['company_id'];
        $com = mysqli_real_escape_string($con,trim($_POST['company']));
        $email = mysqli_real_escape_string($con,trim($_POST['email']));
        $web = mysqli_real_escape_string($con,trim($_POST['web']));
        $home = mysqli_real_escape_string($con,trim($_POST['home']));
        $fax = mysqli_real_escape_string($con,trim($_POST['fax']));

        $sql = "UPDATE company
                SET company_name ='$com', email = '$email', website = '$web', fax = '$fax', number = '$home'
                WHERE company_id = '$id'";
        $result = mysqli_query($con, $sql);
       
    header("Location: companies.php");
?>