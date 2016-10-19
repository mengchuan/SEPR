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
			if ($row['accesslevel'] < 0){
				$message = "You are banned";
			}
			else {
				$message = "Logged in succesfully";
				$_SESSION["username"] = $_POST["username"];
				$_SESSION["avatar"] = $row['avatar'];
				$_SESSION["accesslevel"] = $row['accesslevel'];
				if ($_SESSION["accesslevel"] > 0) {
					header('Location: ?page=administration');
				}
			}
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
		
		$userError;
		$passError;
		$emailError;
		//Secure password using salt. 
		$hash = hash('sha256', $password1);
		 
		function createSalt()
		{
		$text = md5(uniqid(rand(), true));
		return substr($text, 0, 20);
		}
		
		function validateName($name)
		{
			global $userError;
			global $con;
			if(empty($name))
			{
				$userError = "Name required.";
				return false;
			}
			else if(strlen($name)>25)
			{
				$userError = "Name cannot be more than 25 characters long";
				return false;
			}
			else
			{
				$result = mysqli_query($con, "SELECT count(*) FROM users WHERE username='$name' GROUP BY username");
				if(mysqli_num_rows($result) != 0)
				{
					$userError = "Account with this username already exists.";
					return false;
				}
			}
			return true;
		}
		
		function validatePassword($pass1, $pass2)
		{
			global $passError;
			$reg = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/";
			if(empty($pass1))
			{
				$passError = "Password required.";
				return false;
			}else if(!preg_match($reg, $pass1))
			{
				$passError = "Password must be at least 8 characters long and must contain at least 1 upper case, 1 lower case and 1 digit";
				return false;
			}else if(empty($pass2))
			{
				$passError = "Please retype password.";
				return false;
			}else if($pass1 != $pass2)
			{
				$passError = "Passwords do not match.";
				return false;
			}
			return true;
		}
		
		function validateEmail($email1)
		{
		global $emailError;
		global $con;
			$reg = "/[A-Za-z0-9_-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/";
			if(empty($email1))
			{
				$emailError = "Email required.";
				return false;
			}
			else if(!preg_match($reg, $email1))
			{
				$emailError = "Invalid email.";
				return false;
			}
			else
			{
				$result = mysqli_query($con, "SELECT count(*) FROM users WHERE email ='$email1' GROUP BY email");
				if(mysqli_num_rows($result) != 0)
				{
					$emailError = "Account with this email already exists.";
					return false;
				}
			}
			return true;
		}
		 
		 if(!validateName($username))
		 {
			$message = $userError;
		 }else if(!validatePassword($password1, $password2))
		 {
			$message = $passError;
		 }else if(!validateEmail($email))
		 {
			$message = $emailError;
		 }
		 else
		 {
			$salt = createSalt();
			$password = hash('sha256', $salt . $hash);
			$query = "INSERT INTO users ( username, password, email, salt )
					VALUES ( '$username', '$password', '$email', '$salt' );";
					mysqli_query($con, $query);
					$message =  "Succesfully registered";
		 }
    }
}
?>