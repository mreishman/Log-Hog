<?php
try 
{
	$baseModifier = "../../";
	if(!is_readable($baseModifier.'local/layout.php'))
	{
		echo json_encode("error in file permissions");
		exit();
	}
	require_once($baseModifier.'local/layout.php');
	$baseUrl = $baseModifier."local/".$currentSelectedTheme."/";
	require_once($baseUrl.'conf/config.php');
	require_once($baseModifier.'core/conf/config.php');
	require_once('configStatic.php');
	require_once('updateProgressFile.php');
	require_once('commonFunctions.php');
}
catch (Exception $e)
{
	echo json_encode("error in file permissions");
	exit();
}

$varsLoadLite = array("shellOrPhp", "watchList", "lineCountFromJS");

foreach ($varsLoadLite as $varLoadLite)
{
	$$varLoadLite = $defaultConfig[$varLoadLite];
	if(isset($config[$varLoadLite]))
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
$fileDataPOST = null;
if(isset($_POST["fileData"]))
{
	$fileDataPOST = $_POST["fileData"];
}

if($configStatic['version'] != $currentVersionPost)
{
	echo json_encode(false);
	exit();
}

if(isset($updateProgress['percent']) && ($updateProgress['percent'] != 0) && $updateProgress['percent'] != 100)
{
	echo json_encode("update in progress");
	exit();
}
$currentTime = time();
$watchListFolder = array();
foreach($watchList as $key => $value)
{
	if($value["SaveGroup"] === "true")
	{
		continue;
	}
	$path = $value["Location"];
	$filter = $value["Pattern"];
	$fileData = json_decode($value["FileInformation"], true);
	if(is_dir($path))
	{
		$watchListFolder[$key] = getListOfFiles(array(
			"path" 			=> $path,
			"filter"		=> $filter,
			"response"		=> array(),
			"recursive"		=> $value["Recursive"],
			"shellOrPhp"	=> $shellOrPhp,
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
					$diff = $currentTime-filemtime($file);
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
		$responseFilelist[] =  $path;
	}
}

foreach ($responseFilelist as $file)
{
	$currentFileSize = getFileSize($file, $shellOrPhp);
	$response[$file]["size"] = $currentFileSize;
	$responseFileLineCount = -1;
	if($lineCountFromJS === "false")
	{
		if($fileDataPOST !== null && isset($fileDataPOST[$file]) && $fileDataPOST[$file]["size"] === $currentFileSize)
		{
			$responseFileLineCount = $fileDataPOST[$file]["lineCount"];
		}
		else
		{
			$responseFileLineCount = getLineCount($file, $shellOrPhp);
		}
	}
	$response[$file]["lineCount"] = $responseFileLineCount;
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
		$response[$file]["GrepFilter"] = $watchList[$keyFound]["GrepFilter"];
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
				$filesInFolderData = json_decode($watchList[$key]["FileInformation"], true);
				if(isset($filesInFolderData[$file]))
				{
					$dataToUse = $filesInFolderData[$file];
					$response[$file]["ExcludeTrim"] = $dataToUse["Trim"];
					$response[$file]["Name"] = $dataToUse["Name"];
					$response[$file]["AlertEnabled"] = $watchList[$key]["AlertEnabled"];
					if($watchList[$key]["AlertEnabled"] !== "false")
					{
						$response[$file]["AlertEnabled"] = $dataToUse["Alert"];
					}
					$response[$file]["GrepFilter"] = "";
					if(isset($dataToUse["GrepFilter"]))
					{
						$response[$file]["GrepFilter"] = $dataToUse["GrepFilter"];
					}
				}
				else
				{
					$response[$file]["ExcludeTrim"] = $watchList[$key]["ExcludeTrim"];
					$response[$file]["Name"] = "";
					$response[$file]["AlertEnabled"] = $watchList[$key]["AlertEnabled"];
					$response[$file]["GrepFilter"] = "";
				}

				$response[$file]["Group"] = $watchList[$key]["Group"];
				break;
			}
		}
	}
}

echo json_encode($response);
exit();