<?php
$dirType = $_POST['type'];
$folder = "loghogBackupArchiveLogs";
if($dirType !== "archive")
{
	$folder = "loghogBackupHistoryLogs";
}
$fileName = $_POST['file'];
require_once("../../tmp/".$folder."/".$fileName);
echo json_encode($logData);