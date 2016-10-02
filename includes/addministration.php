<?php
if (isset($_GET['delete'])) {
    $con = connectDatabase();

    $delete = $_GET['delete'];
    $content = mysqli_real_escape_string($con, $delete);

    $sql="DELETE FROM `comments` WHERE `comments`.`commentID` = ".$delete;

    if(mysqli_query($con,$sql)){
        $amessage = "Successfully deleted comment.";
    } else {
        $amessage = "Error, can not successfully delete the comment.";
    }
}
?>