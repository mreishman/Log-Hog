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
	$fileData = array();
	$tmpFileData = json_decode($value["FileInformation"]);
	if(!is_null($tmpFileData))
	{
		$fileData = get_object_vars($tmpFileData);
	}
	if(is_dir($path))
	{
		$watchListFolder[$key] = getListOfFiles(array(
			"path" 			=> $path,
			"filter"		=> $filter,
			"response"		=> array(),
			"recursive"		=> $value["Recursive"],
			"data"			=> $fileData
		));
		if($value["AutoDeleteFiles"] !== "")
		{
			foreach ($watchListFolder[$key] as $file)
			{
				$boolToDelete = true;
				if(isset($fileData[$file]))
				{
					$dataToUse = get_object_vars($fileData[$file]);
					if($dataToUse["Delete"] === "true")
					{
						$boolToDelete = false;
					}
				}
				if($boolToDelete)
				{
					$diff = time()-filemtime($file);
					$days = round($diff/86400);
					if($days > (int)$value["AutoDeleteFiles"])
					{
						unlink($file);
						$keyInSubArray = array_search($file, $watchListFolder[$key]);
						unset($watchListFolder[$key][$keyInSubArray]);
					}
				}
			}
		}
		$responseFilelist = array_merge($responseFilelist, $watchListFolder[$key]);
	}
	elseif(file_exists($path))
	{
		array_push($responseFilelist, $path);
	}
}

foreach ($responseFilelist as $file)
{
	$response[$file]["size"] = getFileSize($file, $shellOrPhp);
	$found = false;
	$keyFound = "";
	foreach ($watchList as $key => $value)
	{
		if($value["Location"] === $file)
		{
			$keyFound = $key;
			$found = true;
			break;
		}
	}

	if($found)
	{
		//this is a file that is set in watchlist, use that info
		$response[$file]["ExcludeTrim"] = $watchList[$keyFound]["ExcludeTrim"];
		$response[$file]["Name"] = $watchList[$keyFound]["Name"];
		$response[$file]["AlertEnabled"] = $watchList[$keyFound]["AlertEnabled"];
		$response[$file]["Group"] = $watchList[$keyFound]["Group"];
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
				$filesInFolderData = array();
				$tmpFileData = json_decode($watchList[$key]["FileInformation"]);
				if(!is_null($tmpFileData))
				{
					$filesInFolderData = get_object_vars($tmpFileData);
				}
				if(isset($filesInFolderData[$file]))
				{
					$dataToUse = get_object_vars($filesInFolderData[$file]);
					$response[$file]["ExcludeTrim"] = $dataToUse["Trim"];
					$response[$file]["Name"] = $dataToUse["Name"];
					if($watchList[$key]["AlertEnabled"] !== "false")
					{
						$response[$file]["AlertEnabled"] = $dataToUse]["Alert"];
					}
				}
				else
				{
					$response[$file]["ExcludeTrim"] = $watchList[$key]["ExcludeTrim"];
					$response[$file]["Name"] = "";
					$response[$file]["AlertEnabled"] = $watchList[$key]["AlertEnabled"];
				}

				$response[$file]["Group"] = $watchList[$key]["Group"];
				break;
			}
		}
	}
}

echo json_encode($response);
exit();