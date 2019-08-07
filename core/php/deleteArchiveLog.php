<?php
require_once("class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
if(!$session->validate())
{
	echo json_encode(array("error" => 18));
	exit();
}
$dirType = $_POST['type'];
$folder = "loghogBackupArchiveLogs";
if($dirType !== "archive")
{
	$folder = "loghogBackupHistoryLogs";
}
$fileName = $_POST['file'];
unlink("../../tmp/".$folder."/".$fileName);
echo json_encode(true);