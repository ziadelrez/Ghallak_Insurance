<?php 
    require_once "connection.php";
    // $values = $_POST['query'];
  
    // if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $search = $_POST['s'];
        
        $sql = "SELECT * FROM garage WHERE garage_name LIKE '%".$search."%'";
        $result = mysqli_query($con, $sql);
       
        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
                echo "<a onClick='search_garage(event)' class='list-group list-group-item-action border p-2'>".$row['garage_name']."</a>";
            }
        }
    // }    
       

?>