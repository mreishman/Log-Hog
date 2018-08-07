<?php
$location = $_POST['subFolder'];
$fileName = implode("_DIR_", explode("/", $_POST["key"])).".php";
$fileContents = "<?php $"."logData = ".json_encode($_POST["log"]."; ?>");
if(is_dir("../../".$location))
{
	file_put_contents("../../".$location."Backup".$fileName, $fileContents);
}
echo json_encode(true);