<?php
require_once("class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
$baseModifier = "../../";
require_once($baseModifier.'local/layout.php');
$baseUrl = $baseModifier."local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once($baseModifier.'core/conf/config.php');
require_once('configStatic.php');
require_once("class/core.php");
$core = new core();
$varsLoadLite = array("saveTmpLogNum","saveArchiveLogLimit","saveArchiveLogNum");

foreach ($varsLoadLite as $varLoadLite)
{
	$$varLoadLite = $defaultConfig[$varLoadLite];
	if(array_key_exists($varLoadLite, $config))
	{
		$$varLoadLite = $config[$varLoadLite];
	}
}

//load config data, check for history enabled / number for both archive & temp
$location = $_POST['subFolder'];
$fileName = implode("_DIR_", explode("/", $_POST["key"])).".php";
$fileContents = "<?php $"."logData = ".json_encode($_POST["log"])."; ?>";
$currentTimeStamp = date("Y-m-d-H-i-s");
if($location === "loghogBackupArchiveLogs" && $saveArchiveLogLimit === "false")
{
	//archive logic
}
else
{
	//tmp log logic
	//get list of files in folder that start with fileName.
	$scannedDir = scandir("../../".$location);
	if(!is_array($scannedDir))
	{
		$scannedDir = array($scannedDir);
	}
	$files = array_diff($scannedDir, array('..', '.','placeholder .txt'));
	//Remove any that are not needed
	$listOfMatches = array();
	foreach ($files as $file)
	{
		if(strpos($file, "Backup".$fileName) === 0)
		{
			$listOfMatches[filemtime("../../".$location.$file)] = $file;
		}
	}
	asort($listOfMatches);
	$limitSave = $saveTmpLogNum;
	if($location === "loghogBackupArchiveLogs")
	{
		$limitSave = $saveArchiveLogNum;
	}
	while(count($listOfMatches) > $limitSave)
	{
		//remove first in list
		unlink("../../".$location.reset($listOfMatches));
		array_shift($listOfMatches);
	}

}
if(is_dir("../../".$location))
{
	file_put_contents("../../".$location."Backup".$fileName."-".$currentTimeStamp, $fileContents);
}
echo json_encode(true);