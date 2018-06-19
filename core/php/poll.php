<?php
$baseModifier = "../../";
require_once($baseModifier.'local/layout.php');
$baseUrl = $baseModifier."local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once($baseModifier.'core/conf/config.php');
require_once('configStatic.php');
require_once('commonFunctions.php');

$varsLoadLite = array("shellOrPhp", "logTrimOn", "logSizeLimit","logTrimMacBSD", "logTrimType","TrimSize","enableLogging","buffer","sliceSize","lineCountFromJS","showErrorPhpFileOpen");

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
			$time_start = microtime(true);
			$lineCount = "---";
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
						trimLogLine($filename, $logSizeLimit,$logTrimMacBSD,$buffer, $shellOrPhp, $showErrorPhpFileOpen);
					}
					elseif($logTrimType == 'size') //compair to trimsize value
					{
						trimLogSize($filename, $logSizeLimit,$logTrimMacBSD,$buffer, $shellOrPhp. $showErrorPhpFileOpen);
					}

					if($lineCountFromJS === "false")
					{
						$lineCount = getLineCount($filename, $shellOrPhp);
					}
				}
				//poll logic
				if($pathData["GrepFilter"] == "")
				{
					$dataVar =  tail($filename, $sliceSize, $shellOrPhp);
				}
				else
				{
					$dataVar = tailWithGrep($filename, $sliceSize, $shellOrPhp, $pathData["GrepFilter"]);
				}
			}
			$dataVar = htmlentities($dataVar);
			if($lineCount === "---" && $enableLogging != "false")
			{
				$lineCount = getLineCount($filename, $shellOrPhp);
			}
			$response[$path]["data"] = "";
			if($enableLogging != "false")
			{
				$time = (microtime(true) - $time_start)*1000;
				$response[$path]["data"] = " Limit: ".$logSizeLimit."(".($logSizeLimit+$buffer).") ".$modifier." | Line Count: ".$lineCount." | Time: ".round($time);
			}
			$response[$path]["lineCount"] = $lineCount;
			$response[$path]["log"] = $dataVar;
		}
		catch (Exception $e)
		{
			$response[$path]["log"] = "Error - Maybe insufficient access to read file?";
			$response[$path]["data"] = " Limit: ".$logSizeLimit."(".($logSizeLimit+$buffer).") ".$modifier." | Line Count: --- | Time: ---";
			$response[$path]["lineCount"] = "---";
		}
	}
}
echo json_encode($response);