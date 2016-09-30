<?php  

 require_once(INCLUDES."/db.php");
if (isset($_POST["function"])) {
    if ($_POST["function"] == "addmsg") {
 $con = connectDatabase();
 
 //session_start();
 $username = $_SESSION['username'];
 $content = $_POST['content'];
 
 $username = mysqli_real_escape_string($con, $username);
 $content = mysqli_real_escape_string($con, $content);

if(@$_POST['submit']){  
    $sql="INSERT INTO sepr.comments (`username`, `context`) VALUES ('$username','$content')";
   
   if(mysqli_query($con,$sql)){
      $message = "Successfully added comment.";
} else {
    $message = "Error, can not successfully add the comment.";
}
}     
	}
}
  
?> 