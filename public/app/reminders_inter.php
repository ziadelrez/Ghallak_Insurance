<?php
$agent=$_POST['agent1'];
$start=$_POST['start'];
$end=$_POST['end'];

 header("Location: reminders.php?agent=".$agent."&start=".$start."&end=".$end);
?>