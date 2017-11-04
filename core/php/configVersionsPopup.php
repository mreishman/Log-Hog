<?php

$returnData = array(
	'backupCopiesPresent' => false, 
);

require_once('../../local/layout.php');
$baseUrl = "../../local/".$currentSelectedTheme."/";
if(file_exists($baseUrl."conf/config1.php"))
{
	/* build popup with files*/
	$returnData['backupCopiesPresent'] = true;
	$count = 1;
	$boolVarForLoop = true;
	$arrayOfFiles = array();
	while($boolVarForLoop)
	{
		$baseFile = $baseUrl."conf/config.php";
		$configBackupFile = $baseUrl."conf/config".$count.".php";
		$newFile = $baseUrl."conf/config".$count."Diff.php";
		if(file_exists($configBackupFile))
		{
			xdiff_file_diff($baseFile, $configBackupFile, $newFile);
			array_push($arrayOfFiles, $newFile);
			$count++;
		}
		else
		{
			$boolVarForLoop = false;
		}
	}
	$count--;
	$returnData["arrayOfFiles"] = $arrayOfFiles ;
}

echo json_encode($returnData);