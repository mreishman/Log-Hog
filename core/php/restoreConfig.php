<?php
$restoreTo = $_POST["restoreTo"];

require_once('../../local/layout.php');
$baseUrl = "../../local/".$currentSelectedTheme."/";

// Remove files above current restore to (if any)

if($restoreTo > 1)
{
	for ($i=1; $i < $restoreTo; $i++)
	{ 
		unlink($baseUrl."conf/config".$i.".php");
	}	
}

//move current restore to to tmp file

rename($baseUrl."conf/config".$restoreTo.".php", $baseUrl."conf/configTmp.php");

//Copy current config to config-1

rename($baseUrl."conf/config.php", $baseUrl."conf/config1.php");

//move current tmp file (current restore) to main config

rename($baseUrl."conf/configTmp.php", $baseUrl."conf/config.php");

//move files after current restore (if any) back up to below previous restore to 

$newCount = 1;
$boolForLoop = file_exists($baseUrl."conf/config".($restoreTo+$newCount).".php");
while ($boolForLoop)
{
	rename($baseUrl."conf/config".($restoreTo+$newCount).".php", $baseUrl."conf/config".$newCount.".php");
	$newCount++;
	$boolForLoop = file_exists($baseUrl."conf/config".($restoreTo+$newCount).".php");
}

echo json_encode(true);