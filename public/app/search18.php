<?php 
    require_once "connection.php";

        $search = $_POST['s'];
        $person = $_POST['person'];

        $query3 = "SELECT * FROM person WHERE person_name = '$person'";
        $resultat3 = mysqli_query($con, $query3);
        $row3 = mysqli_fetch_array($resultat3);
        
        $sql = "SELECT * FROM contract WHERE person_id = '" . $row3['person_id'] . "' AND contract_number LIKE '%".$search."%'";
        $result = mysqli_query($con, $sql);
       
        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
                $sql1 = "SELECT * FROM company WHERE company_id = '".$row['company_id']."'";
                $res1 = mysqli_query($con, $sql1);
                $row1 = mysqli_fetch_array($res1);
                
                $sql2 = "SELECT * FROM person WHERE person_id = '".$row['agent']."'";
                $res2 = mysqli_query($con, $sql2);
                $row2 = mysqli_fetch_array($res2); 
                
               echo "<tr onClick='search_contract(\"".$row['contract_number']."\")'><td>".$row['contract_number']."</td><td>".$row['price']."</td><td>".$row1['company_name']."</td><td>".$row2['person_name']."</td><td>".$row['start_date']."</td><td>".$row['end_date']."</td></tr>";
                // echo "<a onClick='search_contract(event)' class='list-group list-group-item-action border p-2'>".$row['contract_number']."</a>";
            }
        }
    // }    
       

?>