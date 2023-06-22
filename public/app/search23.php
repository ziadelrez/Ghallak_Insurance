<?php 
    require_once "connection.php";

        $search = $_POST['s'];
        $person = $_POST['person'];

        $query3 = "SELECT * FROM company WHERE company_name = '$person'";
        $resultat3 = mysqli_query($con, $query3);
        $row3 = mysqli_fetch_array($resultat3);
        
        $sql = "SELECT * FROM accident JOIN accident_cost ON accident.accident_id = accident_cost.accident_id JOIN contract ON accident_cost.contract_id=contract.contract_id AND
        contract.company_id = '" . $row3['company_id'] . "'
        JOIN person ON accident.person_id = person.person_id AND person_name LIKE '%".$search."%'";
        $result = mysqli_query($con, $sql);
       
        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
                $query = "SELECT * FROM person WHERE person_id = '".$row['person_id']."'";
                $res = mysqli_query($con, $query);
                $row2 = mysqli_fetch_array($res);

               echo "<tr onClick='search_accident(\"".$row['accident_id']."\")'><td>".$row['accident_id']."</td><td>".$row2['person_name']."</td><td>".$row['date']."</td><td>".$row['car_number']."</td></tr>";
                // echo "<a onClick='search_contract(event)' class='list-group list-group-item-action border p-2'>".$row['contract_number']."</a>";
            }
        }
    // }    
       

?>