<?php
require_once(INCLUDES."/db.php");

function change_profile_image($username,$temp,$file_ext)
                {
					$con = connectDatabase();
					$avatarname = substr(md5(time()),0,10).'.'.$file_ext;
					$avatar = "Images/Profiles/".$avatarname;
                    $filepath=IMAGES.$avatarname;
                    move_uploaded_file($temp,$filepath);
					
					$username = mysqli_real_escape_string($con, $username);
					
                    mysqli_query($con, "UPDATE users SET avatar = '$avatar' WHERE username = '$username';");
                    $_SESSION['avatar'] = $avatar;
                }
?>