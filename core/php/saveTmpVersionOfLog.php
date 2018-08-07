<?php
$location = $_POST['subFolder'];
$fileName = implode("_", explode("/", $_POST["key"])).".php";
$fileContents = "<?php $"."logData = ".json_encode($_POST["log"]."; ?>");

file_put_contents("../../".$location.$fileName, $fileContents);
echo json_encode(true);