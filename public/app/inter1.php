<?php 
    require_once "connection.php";
    // $values = $_POST['query'];
  
    // if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $search = $_POST['s'];
        
        $sql = "SELECT * FROM contract JOIN car ON contract.car_id = car.car_id AND (car.car_number LIKE '%".$search."%') UNION
        SELECT * FROM contract JOIN car ON contract.car_id = car.car_id AND (car.VIN LIKE '%".$search."%')";
        $result = mysqli_query($con, $sql);
       
        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
                echo "<a onClick='function2(event, ".$row['car_id'].")' class='list-group list-group-item-action border p-2'>".$row['car_number']."</a>";
            }
        }
    // }    

?>