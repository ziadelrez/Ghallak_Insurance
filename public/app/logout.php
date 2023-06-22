<?php
session_start();
//Remove session
session_destroy();

setcookie("adminAcc", "", time()-3600);
setcookie("adminPass", "", time()-3600);
header("Location:index.php");
?>