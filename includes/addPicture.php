<?php
require_once(INCLUDES."/db.php");

function change_profile_image($username,$temp,$file_ext)
                {
					$con = connectDatabase();
                    $filepath='Images/Profiles/'.substr(md5(time()),0,10).'.'.$file_ext;
                    //echo $filepath;
                    move_uploaded_file($temp,$filepath);
                    mysqli_query($con, "UPDATE users SET avatar = '$filepath' WHERE username = '$username';");
                    $_SESSION['sess_avatar'] = $filepath;
                    echo 'Success. <a href="home.php">Reload page</a>';
                    //This header was supposed to be used to reload the page when 
                    //the picture is uploaded so you have to manually refresh the page to see
                    //the change
                    //header('Location:home.php');
                }
?>