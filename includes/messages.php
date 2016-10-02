<?php
			require_once(INCLUDES."/db.php");
			$con = connectDatabase();
			$returnvalue = "";
			$username="";
			$temp="";
			
			$query_string = "select * from `sepr`.`comments`";
			// this part is going to get the comments from the database.
			$query = mysqli_query($con,$query_string) or die(mysql_error());
			
			//echo mysql_num_rows($query);
			while($row = mysqli_fetch_array($query))
             {
                 $comments[] =$row['context'];
                 $usernamec = $row['username']; 
                 $time[]=$row['time'];
                 $usernamea[]=$usernamec;
             }
             if(!empty($comments))
             {
             if(count($comments)<=50)
             {
             for ($i=count($comments)-1;$i>=0;$i--)
             {
                 $temp=$returnvalue;
                 $returnvalue='<p class="commenters">'. $usernamea[$i]."(".$time[$i].'): '.$comments[$i].'</textarea><br/>';
                 $returnvalue = $returnvalue.$temp;
             }
             }
             else
             {
                  for ($i=49;$i>=0;$i--)
             {
                 $temp=$returnvalue;
                 $returnvalue='<p class="commenters">'. $usernamea[$i]."(".$time[$i].'): '. $comments[$i].'</textarea><br/>';
                 $returnvalue = $returnvalue.$temp;
             }
             }
             }
             else
                 echo 'No comment yet.';
             echo $returnvalue;
	if(isset($_SESSION["username"])){// if logged in
?>
	<br/>
	<form method="post" name = "myform" onsubmit="return CheckPost();">  
	<br/>	content:<br/><textarea  name="content" cols="60" rows="9" ></textarea><br/>  
		<input type="hidden" name="function" value="addmsg">
		<input type="submit" name="submit" value="submit" />
	</form>
<?php	
}
?>