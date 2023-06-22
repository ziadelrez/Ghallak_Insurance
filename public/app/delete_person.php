
<?php 
include_once "connection.php";
$sql1 = "SELECT * FROM person WHERE person_name = '".$_GET['person']."'";
$res1 = mysqli_query($con,$sql1);
$row = mysqli_fetch_array($res1);

$sql = "DELETE FROM person WHERE person_name = '".$_GET['person']."'";
$res = mysqli_query($con,$sql);
 
$sql2 = "DELETE FROM types WHERE person_id = '".$row['person_id']."'";
$res2 = mysqli_query($con, $sql2);
if($res && $res2) echo "done";
else echo "not";
header("Location: person.php");
?>
