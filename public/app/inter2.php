<?php
require_once "connection.php";
// $values = $_POST['query'];

// if($_SERVER['REQUEST_METHOD'] == 'POST'){
$search = $_POST['s'];
$person = $_GET['person'];

$query4 = "SELECT * FROM person WHERE person_name = '$person'";
$result4 = mysqli_query($con, $query4);
$row4 = mysqli_fetch_array($result4);
$query5 = "SELECT * FROM car WHERE person_id = '" . $row4['person_id'] . "' and car_number LIKE '%".$search."%' ";
$resultat5 = mysqli_query($con, $query5);

if (mysqli_num_rows($resultat5)) {
    while ($row = mysqli_fetch_assoc($resultat5)) {
        $query6 = "SELECT * FROM car_name WHERE car_name_id = '" . $row['car_name_id'] . "'";
            $result6 = mysqli_query($con, $query6);
            $row6 = mysqli_fetch_array($result6);
        echo "<a onClick='function3(event)' class='list-group list-group-item-action border p-2'>".$row6['name']." | " . $row['car_number'] . "  </a>";
    }
}
    // }    
