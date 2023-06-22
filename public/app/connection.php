
	<?php
        $host = '127.0.0.1:3306';
        $user = 'cttsdjei_hallak_db_user';
        $password = 'hallak@2021';
        $dbname = 'cttsdjei_hallak_insurance';

        $con = mysqli_connect($host, $user, $password, $dbname);
        mysqli_set_charset($con,'utf8');
        
        ?>