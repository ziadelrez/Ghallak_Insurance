<?php 
    require_once "connection.php";
    // $values = $_POST['query'];
  
    // if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $search = $_GET['person'];
        
        $sql = "SELECT * FROM contract WHERE person_id = '$search'";
        $result = mysqli_query($con, $sql);
       
        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
                echo "<a onClick='search_contract(event)' class='list-group list-group-item-action border p-2'>".$row['contract_number']."</a>";
            }
        }
    // }    
       

?>