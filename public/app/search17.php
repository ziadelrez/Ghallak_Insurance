<?php 
    require_once "connection.php";
    // $values = $_POST['query'];
  
    // if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $search = $_GET['person'];
        
        $sql = "SELECT * FROM car_name JOIN car ON car_name.car_name_id = car.car_name_id AND car.person_id = '$search'";
        $result = mysqli_query($con, $sql);
       
        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
                echo "<a onClick='search_car(event)' class='list-group list-group-item-action border p-2'>".$row['name']." | ".$row['car_number']."</a>";
            }
        }
    // }    
       

?>