<?php
require_once("class/core.php");
$core = new core();
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
$dirName = "../../tmp/".$folder."/";
$scandir = [];
if(is_dir($dirName ))
{
	$scannedDir = scandir($dirName );
	if(!is_array($scannedDir))
	{
		$scannedDir = array($scannedDir);
	}
}
$files = array_diff($scannedDir, array('..', '.','placeholder .txt'));
echo json_encode($files);