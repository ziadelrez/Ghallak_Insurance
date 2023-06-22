<?php 
    require_once "connection.php";
    // $values = $_POST['query'];
  
    // if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $search = $_POST['s'];
        
        $sql = "SELECT * FROM person WHERE person_name LIKE '%".$search."%'";
        $result = mysqli_query($con, $sql);
       
        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
                echo "<a onClick='func(event)' class='list-group list-group-item-action border p-2' id='selected'>".$row['person_name']."</a>";
            }
        }
?>