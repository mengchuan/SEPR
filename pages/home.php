<div class="col-sm-8 text-center">
    <h1>SEPR incredible website</h1>
    <p>hello this is our SEPR page.</p>
</div>

<?php
if (!isset($_SESSION["username"])) { // if not logged in
?>
<div class="col-sm-4">
    <div class="col-xs-12 form-group round">
        <h3>Login</h3>
        <form method="post">
            <div class="col-xs-5">
                <label for="usr">Username:</label>
            </div>
            <div class="col-xs-7">
                <input name="username" type="text" class="form-control" id="usr">
            </div>

            <div class="col-xs-5 clear">
                <label for="pwd">Password:</label>
            </div>
            <div class="col-xs-7">
                <input name="password" type="password" class="form-control" id="pwd">
            </div>
            <div class="col-xs-6">
                <input type="hidden" name="function" value="login">
                <input type="submit" class="btn btn-info" value="Login">
            </div>
        </form>
    </div>

    <div class="col-xs-12 form-group round">
        <h3>Register</h3>
        <form method="post">
            <div class="col-xs-5">
                <label for="usr">Username:</label>
            </div>
            <div class="col-xs-7">
                <input name="username" type="text" class="form-control" id="usr">
            </div>

            <div class="col-xs-5 clear">
                <label for="pwd1">Password:</label>
            </div>
            <div class="col-xs-7">
                <input name="password1" type="password" class="form-control" id="pwd1">
            </div>

            <div class="col-xs-5 clear">
                <label for="pwd2">Again:</label>
            </div>
            <div class="col-xs-7">
                <input name="password2" type="password" class="form-control" id="pwd2">
            </div>
			
			<div class="col-xs-5 clear">
                <label for="pwd2">Email:</label>
            </div>
            <div class="col-xs-7">
                <input name="email" type="text" class="form-control" id="email">
            </div>

            <div class="col-xs-6">
                <input type="hidden" name="function" value="register">
                <input type="submit" class="btn btn-info" value="Register">
            </div>
        </form>
    </div>
    <?php
    }
else {
		$username = $_SESSION["username"];
		$pic = $_SESSION["avatar"];
    ?>
<div class="col-sm-4">
    <div class="col-xs-12 round">
        <h3>Welcome <?= $username ?></h3>
		<div class="profilepic">
			<img src="<?php echo $pic ?>" />
			<?php
				include(INCLUDES."/addPicture.php");
				if(isset($_FILES['Photo']))
				{
					if(empty($_FILES['Photo']['name']))
					{
						$fileName='default.png';
					}
					else{
						$allowed=array('jpg','jpeg','gif','png');
						$fileName=($_FILES['Photo']['name']); 
						$file_exten= explode('.',$fileName);
						$file_ext =  strtolower(end($file_exten));
						$tmpName = $_FILES['Photo']['tmp_name'];
						if(in_array($file_ext, $allowed))
							{
								//upload file
							change_profile_image($username,$tmpName,$file_ext);
							}
						else {
							echo "Incorrect file type. Allowed: ";
							echo implode(', ', $allowed);
							}
					}
				}
			?>
			
			<form action="" method="post" enctype="multipart/form-data">
				<input type="file" name="Photo"></input>
				<input type="Submit" value="Submit"></input>
			</form>
			
		</div>
		
    </div>
        <a href="?logout=true" style="padding-bottom:20px;display: block;">Log out</a>
</div>
</br>
<div>
	<form method="post" name="send" >
		<div class="loginBox">
			<div class="loginBoxCenter">
				<p><label for="username">Input Your Old Password&#58;</label></p>
                <p><input type="password"  name="oldpassword" autofocus="autofocus" required="required" autocomplete="off" 
				placeholder="Old Password " value="" /></p>
                <p><label for="username">Input Your New Password &#58;</label></p>
				<p><input type="password"  name="newpassword" required="required" autocomplete="off" 
				placeholder="New Password " value="" /></p>
                <p><label for="username">Input Your New Password Again&#58;</label></p>
				<p><input type="password"  name="newpasswordc" required="required" autocomplete="off" 
				placeholder="New Password confirmation" value="" /></p>
				<input type="hidden" name="function" value="changepassword">
				<input type="submit" name="submit" value="Change Password" />
				<br />
			</div>
		</div>
	</form>
</div>
</br>
    <?php 
    } 
    ?>
</div>




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
?>
<?php
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

 
<script language="text/javascript">  
function CheckPost()  
{  
    if (myform.userName.value=="")
    {  
        alert("please fill the username");  
        myform.user.focus();  
        return false;  
    }  
    if (myform.title.value.length<5)  
    {  
        alert("title more than 5");  
        myform.title.focus();  
        return false;  
    }  
    if (myform.content.value=="")  
    {  
        alert("required content");  
        myform.content.focus();  
        return false;  
    }  
      
}  
</script>