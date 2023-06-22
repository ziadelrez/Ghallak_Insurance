<?php 

	require_once("connection.php");
		
		$Username = mysqli_real_escape_string($con,trim($_POST['username']));
		$Pass = mysqli_real_escape_string($con,trim($_POST['password']));
		$pass1 = md5($Pass);
	// // Add Additional security using sha1 hash of the password
	// $pass2 = sha1($pass1);
	// //Add encryption with salt
	// $salt = "abcd";
	// //Apply the encryption
	// $pass3 = crypt($pass2,$salt);
	// //Add more complexity to the encryption
	// $pass4 = $pass3.$pass2;
    echo $Username;
		$sql = "SELECT * FROM admin WHERE username = '$Username' and password = '$Pass'";
	    $result2 = mysqli_query($con, $sql) or die(mysqli_error($con));
		
		if(mysqli_num_rows($result2)==false){
				header("Location:index.php?error=1#SignIn");
                echo die(mysqli_error($con));
		} else 
		{
			//If it exists, one row will be returned
		$row = mysqli_fetch_array($result2);
		//Start a session
		session_start();
		//Create a session for the admin
			$_SESSION["wp20admin"] = $row["username"];
			// echo $_SESSION["wp20admin"];
			// echo $Username;
			// echo $Pass;
			// echo $pass4;
		
			header("Location:person.php");
		}
		
	?>