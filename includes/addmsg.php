<?php  

 require_once("/db.php");
 $con = connectDatabase();
 
 session_start();
 $username = $_SESSION['username'];
 $content = $_POST['content'];
 
 $username = mysql_real_escape_string ($username);
 $content = mysql_real_escape_string ($content);

if(@$_POST['submit']){  
    $sql="INSERT INTO sepr.comments (`username`, `context`) VALUES ('$username','$content')";
   
   if(mysqli_query($con,$sql)){
      echo '<script>window.location.href="../index.php";</script> ';
} else {
    echo '<script type="text/javascript"> alert("sorry! failed to add data")</script>';
	echo '<script>window.location.href="../index.php";</script> ';
}
}     
  
?> 