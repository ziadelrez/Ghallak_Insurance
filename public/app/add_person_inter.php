<?php
    include_once "connection.php";

        $name =  mysqli_real_escape_string($con,trim($_POST['name']));
       
        $address =  mysqli_real_escape_string($con,trim($_POST['address']));
        $mobile =  mysqli_real_escape_string($con,trim($_POST['mobile']));
        $phone =  mysqli_real_escape_string($con,trim($_POST['phone']));
        $email =  mysqli_real_escape_string($con,trim($_POST['email']));
        $region_id = mysqli_real_escape_string($con,trim($_POST['region']));
        //$checkbox = $_POST['checkbox'];
        if(!isset($_POST['checkbox1'])){
            $check1 = null;
        }
        else $check1 = mysqli_real_escape_string($con,trim($_POST['checkbox1']));
        if(!isset($_POST['checkbox2'])){
            $check2 = null;
        }
        else $check2 = mysqli_real_escape_string($con,trim($_POST['checkbox2']));
        if(!isset($_POST['checkbox3'])){
            $check3 = null;
        }
        else $check3 = mysqli_real_escape_string($con,trim($_POST['checkbox3']));
        if(!isset($_POST['checkbox4'])){
            $check4 = null;
        }
        else $check4 = mysqli_real_escape_string($con,trim($_POST['checkbox4']));
        if(!isset($_POST['checkbox5'])){
            $check5 = null;
        }
        else $check5 = mysqli_real_escape_string($con,trim($_POST['checkbox5']));
 
        if(!isset($_POST['birthdate'])){
            $sql1 = "INSERT INTO person(person_name, birthdate, address, mobile, home_number, email, id, region_id) VALUES ('$name', null, '$address', '$mobile', '$phone', '$email', NULL, '$region_id')";
        $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));
        } else {
            $birthdate =  mysqli_real_escape_string($con,trim($_POST['birthdate']));
            if($birthdate == ""){
            $sql1 = "INSERT INTO person(person_name, birthdate, address, mobile, home_number, email, id, region_id) VALUES ('$name',null, '$address', '$mobile', '$phone', '$email', NULL, '$region_id')";
            $result1 = mysqli_query($con, $sql1) ;
        }else{
            
            $sql1 = "INSERT INTO person(person_name, birthdate, address, mobile, home_number, email, id, region_id) VALUES ('$name', '$birthdate', '$address', '$mobile', '$phone', '$email', NULL, '$region_id')";
        $result1 = mysqli_query($con, $sql1) or die(mysqli_error($con));
        }
        echo "birthday".$birthdate;
        } 
        

        //echo $name;
        $sql2 = "SELECT * FROM person WHERE person_name ='$name' and mobile = '$mobile'";
        $result2 = mysqli_query($con, $sql2);
       
        $row = mysqli_fetch_array($result2);
       
        if($check1 != NULL){
           $sql3 = "INSERT INTO types(person_id, person_type_id) VALUES(".$row['person_id'].", 1 )";
           $result3 = mysqli_query($con, $sql3);    
        }
           
        if($check2 != NULL){
            $sql4 = "INSERT INTO types(person_id, person_type_id) VALUES(".$row['person_id'].", 2 )";
            $result4 = mysqli_query($con, $sql4);    
        }
         
        if($check3 != NULL){
            $sql5 ="INSERT INTO types(person_id, person_type_id) VALUES(".$row['person_id'].", 3 )";
            $result5 = mysqli_query($con, $sql5);   
        }

        if($check4 != NULL){
            $sql6 = "INSERT INTO types(person_id, person_type_id) VALUES(".$row['person_id'].", 4 )";
            $result6 = mysqli_query($con, $sql6);    
        }

        if($check5 != NULL){
            $sql7 = "INSERT INTO types(person_id, person_type_id) VALUES(".$row['person_id'].", 5 )";
            $result7 = mysqli_query($con, $sql7);    
        }

        header("Location: person.php");
    ?>