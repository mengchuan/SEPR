<?php
if (version_compare(PHP_VERSION, '7.0.0') < 0) {
    die("<h1>Use PHP version 7, <a href='https://www.apachefriends.org/xampp-files/7.0.9/xampp-win32-7.0.9-1-VC14-installer.exe'>Press here to install XAMPP with PHP 7</a></h1>");
}

include("config.php");
include INCLUDES."login.php";
include INCLUDES."addmsg.php";
include INCLUDES."changepassword.php";

include INCLUDES."header.php";

include isset($_GET['page']) ? "pages/" . $_GET['page'].".php" : "pages/home.php";

include INCLUDES."footer.php";
?>