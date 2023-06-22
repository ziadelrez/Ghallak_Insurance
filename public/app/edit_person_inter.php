<?php 
    require_once "connection.php";
    // $values = $_POST['query'];
    session_start();

    // foreach($_SESSION['sesh'] as $val){
    //     // echo $val['person_id']."----";
    //     // echo $val['person_type_id']."+++";
    // }
    $id = $_GET['person_id'];
     if(isset($_POST['submit'])){
       
        $name =  mysqli_real_escape_string($con,trim($_POST['name']));
        
        if(!isset($_POST['address'])){
            $address = null;
        }else{
        $address =  mysqli_real_escape_string($con,trim($_POST['address']));
            if($address == ""){
                $address = null;
            }
        }
        
        if(!isset($_POST['mobile'])){
            $mobile = null;
        }else{
         $mobile =  mysqli_real_escape_string($con,trim($_POST['mobile']));
            if($mobile == ""){
                $mobile = null;
            }
        }
        
        if(!isset($_POST['phone'])){
            $phone = null;
        }else{
        $phone =  mysqli_real_escape_string($con,trim($_POST['phone']));
            if($phone == ""){
                $phone = null;
            }
        }
        
        if(!isset($_POST['email'])){
            $email = null;
        }else{
        $email =  mysqli_real_escape_string($con,trim($_POST['email']));
            if($email == ""){
                $email = null;
            }
        }
        
        $region_id = mysqli_real_escape_string($con,trim($_POST['region']));
        $checkbox = $_POST['checkbox'];
 
 if(!isset($_POST['birthdate'])){
            $birthdate = null;
            $sql = "UPDATE person 
                SET person_name = '$name', birthdate = NULL, address = '$address', mobile = '$mobile', home_number = '$phone', email = '$email', id = NULL, region_id = '$region_id'
                WHERE person_id = '$id'";
                
        $result = mysqli_query($con, $sql) or die(mysqli_error($con));
        }else{
            
            if($birth == "" || $birth == null){
                $birthdate = NULL;
                $sql = "UPDATE person 
                SET person_name = '$name', birthdate = NULL, address = '$address', mobile = '$mobile', home_number = '$phone', email = '$email', id = NULL, region_id = '$region_id'
                WHERE person_id = '$id'";
                echo $sql;
        $result = mysqli_query($con, $sql) or die(mysqli_error($con));
            }
            else{
                $birthdate =  $_POST['birthdate'];
            $sql = "UPDATE person 
                SET person_name = '$name', birthdate = '$birthdate', address = '$address', mobile = '$mobile', home_number = '$phone', email = '$email', id = NULL, region_id = '$region_id'
                WHERE person_id = '$id'";
                echo $sql;
        $result = mysqli_query($con, $sql) or die(mysqli_error($con));
            }
        }
        
        
        
        foreach($_SESSION['sesh'] as $av){
            $arr[] = $av['person_type_id'];
        }
        $array = array_diff($checkbox, $arr);
                foreach($array as $value){
                    $query = "INSERT INTO types(person_id, person_type_id) VALUES('$id', '$value')";
                    $ress = mysqli_query($con, $query);
                    // if($ress) echo "bravo"; 
                    // else echo "noo";
                }

        $array2 = array_diff($arr, $checkbox);
            foreach($array2 as $key){
                    $query2 = "DELETE FROM types WHERE person_id = '$id' AND person_type_id = '$key'";
                    $resss = mysqli_query($con, $query2) ;
                    // if($resss) echo "nmahet";
                    // else echo "ma nmahet";
            }
        
        
       
       header("Location: person.php");
        
    }    
       

?>