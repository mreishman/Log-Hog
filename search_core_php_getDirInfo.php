<?php
include("commonFunctions.php");
echo json_encode(getDirContents($_POST['dir']));
?>