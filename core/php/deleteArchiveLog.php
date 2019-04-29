<?php
$dirType = $_POST['type'];
$folder = "loghogBackupArchiveLogs";
if($dirType !== "archive")
{
	$folder = "loghogBackupHistoryLogs";
}
$fileName = $_POST['file'];
unlink("../../tmp/".$folder."/".$fileName);
echo json_encode(true);