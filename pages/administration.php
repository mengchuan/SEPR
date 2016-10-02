<?php
if ($_SESSION["accesslevel"] <= 0) {
    die("No rights to see this page");
}
include INCLUDES."addministration.php";
$administration = true;
?>
<div class="col-lg-12 text-center">
    <h1>Administration</h1>
    <h3><?= $amessage ?></h3>
    <?php include INCLUDES."messages.php"; ?>
</div>