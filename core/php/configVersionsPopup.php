<?php

$returnData = array(
	'backupCopiesPresent' => false, 
);

require_once('./class.Diff.php');
require_once('../../local/layout.php');
$baseUrl = "../../local/".$currentSelectedTheme."/";
if(file_exists($baseUrl."conf/config1.php"))
{
	/* build popup with files*/
	$returnData['backupCopiesPresent'] = true;
	$count = 1;
	$boolVarForLoop = true;
	$arrayOfFiles = array();
	$arrayOfDiffs = array();
	while($boolVarForLoop)
	{
		$baseFile = $baseUrl."conf/config.php";
		$configBackupFile = $baseUrl."conf/config".$count.".php";
		if(file_exists($configBackupFile))
		{
			array_push($arrayOfDiffs, Diff::toHTML(Diff::compareFiles($baseFile, $configBackupFile)));
			array_push($arrayOfFiles, $configBackupFile);
			$count++;
		}
		else
		{
			$boolVarForLoop = false;
		}
	}
	$count--;
	$returnData["arrayOfFiles"] = $arrayOfFiles ;
	$returnData["arrayOfDiffs"] = $arrayOfDiffs ;
}

echo json_encode($returnData);