<?php
$baseModifier = "../../";
require_once($baseModifier.'local/layout.php');
$baseUrl = $baseModifier."local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once($baseModifier.'core/conf/config.php');
require_once('configStatic.php');
require_once('commonFunctions.php');

$varsLoadLite = array("shellOrPhp", "logTrimOn", "logSizeLimit","logTrimMacBSD", "logTrimType","TrimSize","enableLogging","buffer","sliceSize");

foreach ($varsLoadLite as $varLoadLite)
{
	$$varLoadLite = $defaultConfig[$varLoadLite];
	if(array_key_exists($varLoadLite, $config))
	{
		$$varLoadLite = $config[$varLoadLite];
	}
}

$logSizeLimit = intval($logSizeLimit);

$modifier = "lines";
if($logTrimType == 'size')
{
	$modifier = $TrimSize;
	$logSizeLimit = convertToSize($TrimSize, $logSizeLimit);
}

$arrayToUpdate = array();
$response = array();

if(isset($_POST['arrayToUpdate']))
{
	$arrayToUpdate = $_POST['arrayToUpdate'];
	foreach($arrayToUpdate as $path => $pathData)
	{
		try
		{
			if($enableLogging != "false")
			{
				$time_start = microtime(true);
			}

			$filename = preg_replace('/([()"])/S', '$1', $path);
			if(!file_exists($filename))
			{
				$dataVar = "Error - File does not exist";
			}
			elseif(!is_readable($filename))
			{
				$dataVar = "Error - File is not Readable";
			}
			elseif(filesize($filename) === 0)
			{
				$dataVar = "This file is empty. This should not be displayed.";
			}
			else
			{
				//trim file
				if($logTrimOn == "true" && $pathData["ExcludeTrim"] === "false")
				{
					if($logTrimType == 'lines')
					{
						trimLogLine($filename, $logSizeLimit,$logTrimMacBSD,$buffer, $shellOrPhp);
					}
					elseif($logTrimType == 'size') //compair to trimsize value
					{
						trimLogSize($filename, $logSizeLimit,$logTrimMacBSD,$buffer, $shellOrPhp);
					}
				}
				//poll logic
				$dataVar =  tail($filename, $sliceSize, $shellOrPhp);
			}
			$dataVar = htmlentities($dataVar);

			if($enableLogging != "false")
			{
				$lineCount = "0";
				if($dataVar === "" || is_null($dataVar) || $dataVar === "Error - Maybe insufficient access to read file?" || $dataVar === "Error - File is not Readable")
				{
					$lineCount = "---";
				}
				elseif($dataVar !== "This file is empty. This should not be displayed.")
				{
					$lineCount = getLineCount($filename, $shellOrPhp);
				}

				$time = (microtime(true) - $time_start)*1000;
				$response[$path."dataForLoggingLogHog051620170928"] = " Limit: ".$logSizeLimit."(".($logSizeLimit+$buffer).") ".$modifier." | Line Count: ".$lineCount." | Time: ".round($time);
			}
			$response[$path] = $dataVar;
		}
		catch (Exception $e)
		{
			$response[$path] = "Error - Maybe insufficient access to read file?";
			$response[$path."dataForLoggingLogHog051620170928"] = " Limit: ".$logSizeLimit."(".($logSizeLimit+$buffer).") ".$modifier." | Line Count: --- | Time: ---";
		}
	}
}
echo json_encode($response);