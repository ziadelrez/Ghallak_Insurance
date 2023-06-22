<?php 
    require_once "connection.php";
    // $values = $_POST['query'];
  
    // if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $search = $_POST['s'];
        
        $sql = "SELECT * FROM accident WHERE accident_id LIKE '%".$search."%'";
        $result = mysqli_query($con, $sql);
       
        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
                echo "<a href='edit_accident.php?accident_id=".$row['accident_id']."' class='list-group list-group-item-action border p-2'>".$row['accident_id']."</a>";
            }
        }
    // }    
       

?>