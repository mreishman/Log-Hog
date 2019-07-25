<?php
require_once("class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
$baseUrl = "../../local/";
//there is custom information, use this
require_once('../../local/layout.php');
$baseUrl .= $currentSelectedTheme."/";

/* Check for backup config stuff */
$count = 1;
$showConfigBackupClear = false;
$arrayOfFiles = array();
while (file_exists($baseUrl."conf/config".$count.".php"))
{
	array_push($arrayOfFiles, $baseUrl."conf/config".$count.".php");
	if(!$showConfigBackupClear)
	{
		$showConfigBackupClear = true;
	}
	$count++;
}

foreach ($arrayOfFiles as $file)
{
	unlink($file);
}

echo json_encode(true);