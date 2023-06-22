<?php 
    require_once "connection.php";
    // $values = $_POST['query'];
  
    // if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $search = $_POST['s'];
        
        $sql = "SELECT * FROM contract WHERE contract_number LIKE '%".$search."%' ORDER BY start_date DESC";
        $result = mysqli_query($con, $sql);
       
        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
                echo "<a href='edit_contract.php?contract_number=".$row['contract_number']."' class='list-group list-group-item-action border p-2'>".$row['contract_number']."</a>";
            }
        }
    // }    
       

?>