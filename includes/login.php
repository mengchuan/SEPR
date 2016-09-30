<?php
session_start();
require_once(INCLUDES."/db.php");

if (isset($_GET['logout'])) {
    unset($_SESSION['username']);
	unset($_SESSION['avatar']);
    header("HTTP/1.1 301 Moved Permanently");
    header("Location : ".$_SERVER['PHP_SELF']);
    die();
}

if (isset($_POST["function"])) {
    if ($_POST["function"] == "login") {
        $con = connectDatabase();

        $userName = $_POST["username"];
        $password = $_POST["password"];
		$userName = mysqli_real_escape_string($con,$userName);

        $query = "SELECT username,password,salt, avatar, accesslevel FROM users WHERE username = '$userName'";

        $result = mysqli_query( $con, $query);

        $row = mysqli_fetch_array($result);
		
		$hash = hash('sha256', $row['salt'] . hash('sha256', $password) );
        if($hash == $row['password']){
            $message = "Logged in succesfully";
            $_SESSION["username"] = $_POST["username"];
			$_SESSION["avatar"] = $row['avatar'];
			$_SESSION["accesslevel"] = $row['accesslevel'];
        }
        else {
            $message = "Wrong username or password";
        }
    }
    else if ($_POST["function"] == "register") {
		$con = connectDatabase();

		$username = $_POST['username'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		$email = $_POST['email'];
		
		//Secure password using salt. 
		$hash = hash('sha256', $password1);
		 
		function createSalt()
		{
		$text = md5(uniqid(rand(), true));
		return substr($text, 0, 20);
		}
		 
		$salt = createSalt();
		$password = hash('sha256', $salt . $hash);
		 
		//sanitize username
		$username = mysqli_real_escape_string($con,$username);
		$result = mysqli_query($con, "SELECT count(*) FROM users WHERE username='$username' GROUP BY username");
		$rowcount = mysqli_num_rows($result);
		//$querya = mysqli_query($con,"SELECT count(*) FROM member WHERE username='$username'");
		if ($rowcount != 0)
		{
		  //header('Location:registration.html');
		  $message = "Username already exists.";
		}
	  else{
			if($password1 != $password2){
				$message =  "Your passwords do not match.";
				//header('Location: registration.html');
			}
			else{
					$query = "INSERT INTO users ( username, password, email, salt )
					VALUES ( '$username', '$password', '$email', '$salt' );";
					mysqli_query($con, $query);
					$message =  "Succesfully registered";
			}
		}
    }
}
?>