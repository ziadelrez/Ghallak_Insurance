<?php
    include_once "connection.php";

    if(isset($_POST['submit8'])){
        $com = $_POST['company'];
        $email = $_POST['email'];
        $web = $_POST['web'];
        $home = $_POST['home'];
        $fax = $_POST['fax'];
        $region = $_POST['region'];

        $sql = "INSERT INTO company(company_name, email, website, fax, number, region_id) VALUES('$com', '$email', '$web', '$fax', '$home', '$region')";
        $result = mysqli_query($con, $sql);

}
header("Location: companies.php");
?>