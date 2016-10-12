<div class="col-sm-8 text-center">
    <h1>SEPR incredible website</h1>
    <p>hello this is our SEPR page.</p>
    <?php include INCLUDES."messages.php" ?>
</div>

<?php
if (!isset($_SESSION["username"])) { // if not logged in
?>
<script type="text/javascript" src="includes/validation.js"></script>
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
        <form method="post" onsubmit = "return validateForm();">
			<div class = "row">
				<div class="col-xs-5">
					<label for="usr">Username:</label>
				</div>
				<div class="col-xs-7">
					<input name="username" type="text" class="form-control" id="user" onblur="validateName();">
				</div>
			</div>
			<div class = "row">
				<label id="usernamePrompt"></label>
			</div>
			
			<div class = "row">
				<div class="col-xs-5 clear">
					<label for="pwd1">Password:</label>
				</div>
				<div class="col-xs-7">
					<input name="password1" type="password" class="form-control" id="pwd1" onblur="validatePassword();">
				</div>
			</div>
			<div class = "row">
				<label id="passwordPrompt"></label>
			</div>
			
			<div class = "row">
				<div class="col-xs-5 clear">
					<label for="pwd2">Again:</label>
				</div>
				<div class="col-xs-7">
					<input name="password2" type="password" class="form-control" id="pwd2" onblur="validatePassword2();">
				</div>
			</div>
			<div class="row">
                <label id="password2Prompt"></label>
            </div>
			
			<div class = "row">
				<div class="col-xs-5 clear">
					<label for="pwd2">Email:</label>
				</div>
				<div class="col-xs-7">
					<input name="email" type="text" class="form-control" id="email" onblur="validateEmail();">
				</div>
			</div>
			<div class="row">
                <label id="emailPrompt"></label>
            </div>

            <div class="col-xs-6">
                <input type="hidden" name="function" value="register">
                <input type="submit" class="btn btn-info" value="Register">
            </div>
			<div class = "row">
				<label id = "submitPrompt"></label>
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
							//echo '<img src = '+ $_SESSION["avatar"]+ '/>';
							//having problems when trying to reload page as we have output on line 79
							}
						else {
							echo "Incorrect file type. Allowed: ";
							echo implode(', ', $allowed);
							}
					}
				}
			?>
			<img src="<?php echo $pic ?>" />
			<form action="" method="post" enctype="multipart/form-data">
				<input type="file" name="Photo"></input>
				<input type="Submit" class="btn btn-info" value="Submit"></input>
			</form>
			<a href="?logout=true" style="padding-bottom:20px;display: block; clear: both;">Log out</a>
		</div>
		
    </div>
    <div class="col-xs-12 round">
	<form method="post" name="send" onsubmit = "return validateForm(); >
        <h3>Change password</h3>
		<div class="loginBox">
			<div class="loginBoxCenter">
				<p><label for="username">Input Your Old Password&#58;</label></p>
                <p><input class="form-control" type="password"  name="oldpassword" autofocus="autofocus" required="required" autocomplete="off" 
				placeholder="Old Password " value="" onblur="validatePassword(); /></p>
                <p><label for="username">Input Your New Password &#58;</label></p>
				<p><input class="form-control" type="password"  name="newpassword" required="required" autocomplete="off" 
				placeholder="New Password " value="" onblur="validatePassword(); /></p>
                <p><label for="username">Input Your New Password Again&#58;</label></p>
				<p><input class="form-control" type="password"  name="newpasswordc" required="required" autocomplete="off" 
				placeholder="New Password confirmation" value="" onblur="validatePassword2();/></p>
				<input type="hidden" name="function" value="changepassword">
				<input class="btn btn-info" type="submit" name="submit" value="Change Password" />
				<br />
			</div>
		</div>
	</form>
    </div>    
</div>

    <?php 
    } 
    ?>
</div>
 
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