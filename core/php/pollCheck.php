<?php
$baseModifier = "../../";
require_once($baseModifier.'local/layout.php');
$baseUrl = $baseModifier."local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once($baseModifier.'core/conf/config.php');
require_once('configStatic.php');
require_once('updateProgressFile.php');
require_once('commonFunctions.php');

$varsLoadLite = array("shellOrPhp", "watchList");

foreach ($varsLoadLite as $varLoadLite)
{
	$$varLoadLite = $defaultConfig[$varLoadLite];
	if(array_key_exists($varLoadLite, $config))
	{
		$$varLoadLite = $config[$varLoadLite];
	}
}

$response = array();
$responseFilelist = array();
$currentVersionPost = $configStatic["version"];
if(isset($_POST['currentVersion']))
{
	$currentVersionPost = $_POST['currentVersion'];
}

if($configStatic['version'] != $currentVersionPost)
{
	echo json_encode(false);
	exit();
}

if(array_key_exists('percent', $updateProgress) && ($updateProgress['percent'] != 0) && $updateProgress['percent'] != 100)
{
	echo json_encode("update in progress");
	exit();
}

$watchListFolder = array();

foreach($watchList as $key => $value)
{
	$path = $value["Location"];
	$filter = $value["Pattern"];
	if(is_dir($path))
	{
		$responseFilelist = getListOfFiles(array(
			"path" 			=> $path,
			"filter"		=> $filter,
			"response"		=> $responseFilelist,
			"recursive"		=> $value["Recursive"]

		));
		$watchListFolder[$key] = getListOfFiles(array(
			"path" 			=> $path,
			"filter"		=> $filter,
			"response"		=> array(),
			"recursive"		=> $value["Recursive"]
		));
	}
	elseif(file_exists($path))
	{
		array_push($responseFilelist, $path);
	}
}

foreach ($responseFilelist as $file)
{
	$response[$file]["size"] = getFileSize($file, $shellOrPhp);
	if(isset($watchList[$file]))
	{
		//this is a file that is set in watchlist, use that info
		$response[$file]["ExcludeTrim"] = $watchList[$file]["ExcludeTrim"];
	}
	else
	{
		foreach ($watchListFolder as $key => $value)
		{
			$found = false;
			foreach ($value as $fileInner)
			{
				if($fileInner === $file)
				{
					$found = true;
					break;
				}
			}
			if($found)
			{
				//this file is in that folder, use that info

				//check if file has specific info in folder
				if(false)
				{

				}
				else
				{
					$response[$file]["ExcludeTrim"] = $watchList[$key]["ExcludeTrim"];
				}
				break;
			}
		}
	}
}

echo json_encode($response);
exit();