<?php 
    require_once "connection.php";
    // $values = $_POST['query'];
  
    // if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $search = $_POST['s'];
        
        $sql = "SELECT * FROM person JOIN types ON person.person_id = types.person_id AND types.person_type_id = '2' AND person.person_name LIKE '%".$search."%'";
        $result = mysqli_query($con, $sql);
       
        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
                echo "<a  onClick='search_agent(event)' class='list-group list-group-item-action border p-2'>".$row['person_name']."</a>";
            }
        }
    // }    
       

?>