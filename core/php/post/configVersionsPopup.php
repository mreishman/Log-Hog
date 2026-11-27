<?php
$returnData = array(
	'backupCopiesPresent' => false,
);
require_once("../class/core.php");
$core = new core();
require_once('../class/diff.php');
require_once("../class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl = "../../../local/".$currentSelectedTheme."/";
$settingsLock = settingsData::lock($baseUrl."conf");
if(settingsData::exists($baseUrl."conf/config1.json"))
{
	/* build popup with files*/
	$returnData['backupCopiesPresent'] = true;
	$count = 1;
	$boolVarForLoop = true;
	$arrayOfFiles = array();
	$arrayOfDiffs = array();
	while($boolVarForLoop)
	{
		$baseFile = $baseUrl."conf/config.json";
		$configBackupFile = $baseUrl."conf/config".$count.".json";
		if(settingsData::exists($configBackupFile))
		{
			array_push($arrayOfDiffs, diff::toHTML(diff::compare(
				settingsData::encode(settingsData::read($baseFile, 'config')),
				settingsData::encode(settingsData::read($configBackupFile, 'config'))
			)));
			array_push($arrayOfFiles, $configBackupFile);
			$count++;
		}
		else
		{
			$boolVarForLoop = false;
		}
	}
	$returnData["arrayOfFiles"] = $arrayOfFiles ;
	$returnData["arrayOfDiffs"] = $arrayOfDiffs ;
}
echo json_encode($returnData);
