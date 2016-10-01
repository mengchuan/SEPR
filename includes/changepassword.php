<?php

require_once(INCLUDES."/db.php");
if (isset($_POST["function"])) {
    if ($_POST["function"] == "changepassword") {
	$con = connectDatabase();

		$username = $_SESSION['username'];
		$oldpassword = $_POST['oldpassword'];
		$password1 = $_POST['newpassword'];
		$password2 = $_POST['newpasswordc'];
		
		if($password1 != $password2){
			$message =  "Your passwords do not match.";
			//header('Location: registration.html');
		}
		else{
			$username = mysqli_real_escape_string($con,$username);
			$query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
			$row = mysqli_fetch_array($query);
			$oldpasswordc = hash('sha256', $row['salt'] . hash('sha256', $oldpassword));
			$result = mysqli_query($con, "SELECT * FROM users WHERE username='$username' and password = '$oldpasswordc'");
			$rowcount = mysqli_num_rows($result);
			
			if ($rowcount == 0)
			{
				$message = "Wrong old password";
			}
			else{
				function createSalt()
				{
					$text = md5(uniqid(rand(), true));
					return substr($text, 0, 20);
				}
				//Secure password using salt. 
				$hash = hash('sha256', $password1);
				
				$salt = createSalt();
				$password1 = hash('sha256', $salt . $hash);
				$message = $password1 . " " . $username;
				$query = "Update users set `password` = '$password1', `salt` = '$salt' WHERE username = '$username'";
				mysqli_query($con, $query);
				$message =  "password succesfully updated.";
			}
		}
	}
}
?>