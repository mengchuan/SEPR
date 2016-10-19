<?php
			require_once(INCLUDES."/db.php");
			$con = connectDatabase();
			$returnvalue = "";
			$username="";
			$temp="";
			
			//$query_string = "select * from `comments`";
			//updated it so you can also check access level, so only users with higher access level can delete another user's comments.
			$query_string = "select comments.*,accesslevel from comments inner join users where comments.username = users.username";
			// this part is going to get the comments from the database.
			$query = mysqli_query($con,$query_string) or die(mysql_error());
			
			//echo mysql_num_rows($query);
			while($row = mysqli_fetch_array($query))
             {
                 $ids[] =$row['commentID'];
                 $comments[] =$row['context'];
                 $usernamec = $row['username']; 
                 $time[]=$row['time'];
				 $access[] = $row['accesslevel'];
                 $usernamea[]=$usernamec;
             }
             if(!empty($comments))
             {
             for ($i=count($comments)-1;$i>=0;$i--)
             {
                 $temp=$returnvalue;
                 if (isset($administration) && $_SESSION["accesslevel"] > $access[$i]) {
                    $returnvalue='<p class="commenters"><a href="index.php?page=administration&delete='.$ids[$i].'">Delete comment</a> '. $usernamea[$i].' <a href="index.php?page=administration&ban='.$usernamea[$i].'">Ban user</a> ('.$time[$i].'): '.$comments[$i].'</p><br/>';
                 }
                 else {
                    $returnvalue='<p class="commenters">'. $usernamea[$i]."(".$time[$i].'): '.$comments[$i].'</p><br/>';
                 }
                 $returnvalue = $returnvalue.$temp;
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