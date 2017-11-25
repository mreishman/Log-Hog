<?php
$baseUrl = "../../core/";
if(file_exists('../../local/layout.php'))
{
	$baseUrl = "../../local/";
	//there is custom information, use this
	require_once('../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
require_once('../../core/php/configStatic.php');

$modifier = "lines";
$enableSystemPrefShellOrPhp = $defaultConfig['enableSystemPrefShellOrPhp'];
$logTrimOn = $defaultConfig['logTrimOn'];
$logSizeLimit = $defaultConfig['logSizeLimit'];
$logTrimMacBSD = $defaultConfig['logTrimMacBSD'];
$logTrimType = $defaultConfig['logTrimType'];
$TrimSize = $defaultConfig['TrimSize'];
$enableLogging = $defaultConfig['enableLogging'];
$buffer = $defaultConfig['buffer'];

if(array_key_exists('enableSystemPrefShellOrPhp', $config))
{
	$enableSystemPrefShellOrPhp = $config['enableSystemPrefShellOrPhp'];
}
if(array_key_exists('logTrimOn', $config))
{
	$logTrimOn = $config['logTrimOn'];
}
if(array_key_exists('logSizeLimit', $config))
{
	$logSizeLimit = $config['logSizeLimit'];
}
if(array_key_exists('logTrimMacBSD', $config))
{
	$logTrimMacBSD = $config['logTrimMacBSD'];
}
if(array_key_exists('logTrimType', $config))
{
	$logTrimType = $config['logTrimType'];
}
if(array_key_exists('TrimSize', $config))
{
	$TrimSize = $config['TrimSize'];
}
if(array_key_exists('enableLogging', $config))
{
	$enableLogging = $config['enableLogging'];
}
if(array_key_exists('buffer', $config))
{
	$buffer = $config['buffer'];
}

$logSizeLimit = intval($logSizeLimit);

if($logTrimType == 'size')
{
	$modifier = $TrimSize;
	if($TrimSize == "KB")
	{
		$logSizeLimit *= 1024;
	}
	elseif($TrimSize == "M")
	{
		$logSizeLimit *= (1000 * 1000);
	}
	elseif($TrimSize == "MB")
	{
		$logSizeLimit *= (1024 * 1024);
	}
	else
	{
		$logSizeLimit *= 1000;
	}
}


function tail($filename, $sliceSize, $shellOrPhp, $logTrimCheck, $logSizeLimit,$logTrimMacBSD,$logTrimType,$buffer)
{
	if($logTrimCheck == "true")
	{
		if($logTrimType == 'lines')
		{
			$lineCount = shell_exec('wc -l < ' . $filename);
			if($lineCount > ($logSizeLimit+$buffer))
			{
				if($logTrimMacBSD == "true")
				{
					shell_exec('sed -i "'.$filename.'" "1,' . ($lineCount - $logSizeLimit) . 'd" ' . $filename);
				}
				else
				{
					shell_exec('sed -i "1,' . ($lineCount - $logSizeLimit) . 'd" ' . $filename);
				}
			}
		}
		elseif($logTrimType == 'size') //compair to trimsize value
		{
			$maxForLoop = 0;
			$trimFileBool = true;
			while ($trimFileBool && $maxForLoop < 10)
			{
				$filesizeForFile = shell_exec('wc -c < '.$filename);
				if($filesizeForFile > $logSizeLimit+$buffer)
				{
					$numOfLinesToRemoveTo = 2;
					if($filesizeForFile > (2*$logSizeLimit) && $maxForLoop < 2)
					{
						$lineCountForFile = shell_exec('wc -l < ' . $filename);
						$numOfLinesAllowed = 2*($logSizeLimit/($filesizeForFile/$lineCountForFile));
						$numOfLinesToRemoveTo = round($lineCountForFile - $numOfLinesAllowed);
					}
					if($logTrimMacBSD == "true")
					{
						shell_exec('sed -i "'.$filename.'" "1,' . $numOfLinesToRemoveTo . 'd" ' . $filename);
					}
					elseif($logTrimMacBSD == "false")
					{
						shell_exec('sed -i "1,' . $numOfLinesToRemoveTo . 'd" ' . $filename);
					}
				}
				else
				{
					$trimFileBool = false;
				}
				$maxForLoop++;
			}
		}
	}

	if($shellOrPhp == "true")
	{
		$data =  trim(tailCustom($filename, $sliceSize));
	}
	else
	{
		$data = trim(shell_exec('tail -n ' . $sliceSize . ' "' . $filename . '"'));
	}

	if($data === "" || is_null($data))
	{
		if($shellOrPhp == "true")
		{
			$data = trim(shell_exec('tail -n ' . $sliceSize . ' "' . $filename . '"'));
		}
		else
		{
			$data = trim(tailCustom($filename, $sliceSize));
		}

		if($data === "" || is_null($data))
		{
			$data = "Error - Maybe insufficient access to read file?";
		}
	}
	return $data;
}


/**
 * Slightly modified version of http://www.geekality.net/2011/05/28/php-tail-tackling-large-files/
 * @author Torleif Berger, Lorenzo Stanco
 * @link http://stackoverflow.com/a/15025877/995958
 * @license http://creativecommons.org/licenses/by/3.0/
 */
function tailCustom($filepath, $lines = 1, $adaptive = true)
{
	$fileOpened = @fopen($filepath, "rb");
	if($fileOpened === false)
	{
		return false;
	}
	if(!$adaptive)
	{
		$buffer = 4096;
	}
	else
	{
		$buffer = ($lines < 2 ? 64 : ($lines < 10 ? 512 : 4096));
	}
	fseek($fileOpened, -1, SEEK_END);
	if(fread($fileOpened, 1) != "\n")
	{
		$lines -= 1;
	}

	$output = '';
	$chunk = '';
	while (ftell($fileOpened) > 0 && $lines >= 0)
	{
		$seek = min(ftell($fileOpened), $buffer);
		fseek($fileOpened, -$seek, SEEK_CUR);
		$output = ($chunk = fread($fileOpened, $seek)) . $output;
		fseek($fileOpened, -mb_strlen($chunk, '8bit'), SEEK_CUR);
		$lines -= substr_count($chunk, "\n");
	}
	while ($lines++ < 0)
	{
		$output = substr($output, strpos($output, "\n") + 1);
	}
	fclose($fileOpened);
	return trim($output);
}


$response = array();
foreach($_POST['arrayToUpdate'] as $path)
{
	try
	{
		if($enableLogging != "false")
		{
			$time_start = microtime(true);
		}


		$filename = preg_replace('/([()"])/S', '$1', $path);
		if(!is_readable($filename))
		{
			$dataVar = "Error - File is not Readable";
		}
		elseif(filesize($filename) === 0)
		{
			$dataVar = "This file is empty. This should not be displayed.";
		}
		else
		{
			$dataVar =  tail($filename, $config['sliceSize'], $enableSystemPrefShellOrPhp, $logTrimOn, $logSizeLimit,$logTrimMacBSD,$logTrimType,$buffer);
		}
		$dataVar = htmlentities($dataVar);


		if($enableLogging != "false")
		{
			$lineCount = "0";
			$filesizeForFile = "0";
			if($dataVar == "" || is_null($dataVar) || $dataVar === "Error - Maybe insufficient access to read file?" || $dataVar === "Error - File is not Readable")
			{
				$lineCount = "---";
				$filesizeForFile = "---";
			}
			else
			{
				if($dataVar != "This file is empty. This should not be displayed.")
				{
					$lineCount = shell_exec('wc -l < ' . $filename);
					$filesizeForFile = shell_exec('wc -c < '.$filename);
				}
			}
			$time_end = microtime(true);
			$time = $time_end - $time_start;
			$time *= 1000;
			$response[$path."dataForLoggingLogHog051620170928"] = " Limit: ".$logSizeLimit."(".($logSizeLimit+$buffer).") ".$modifier." | Line Count: ".$lineCount." | File Size: ".$filesizeForFile." | Time: ".round($time);
		}
		$response[$path] = $dataVar;
	}
	catch (Exception $e)
	{
		$response[$path] = "Error - Maybe insufficient access to read file?";
		$response[$path."dataForLoggingLogHog051620170928"] = " Limit: ".$logSizeLimit."(".($logSizeLimit+$buffer).") ".$modifier." | Line Count: --- | File Size: --- | Time: ---";
	}
}
echo json_encode($response);
?>