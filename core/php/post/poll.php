<?php
require_once("../class/core.php");
$core = new core();
require_once("../class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
if(!$session->validate())
{
	echo json_encode(array("error" => 18));
	exit();
}
$baseModifier = "../../../";
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl = $baseModifier."local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once($baseModifier.'core/conf/config.php');
require_once('../configStatic.php');
require_once('../class/poll.php');
$poll = new poll();

$varsLoadLite = array("shellOrPhp", "logTrimOn", "logSizeLimit","logTrimMacBSD", "logTrimType","TrimSize","enableLogging","buffer","sliceSize","lineCountFromJS","showErrorPhpFileOpen","advancedLogFormatEnabled","logFormatFileEnable","logFormatFileLinePadding","logFormatFilePermissions","filePathAlternatives");

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
	$logSizeLimit = $poll->convertToSize($TrimSize, $logSizeLimit);
}

$filePathAlternativesArray = json_decode($filePathAlternatives, true);
$sortedFilePathAlternativesArray = [];
$arrayToAdd = [];
$toggle = false;
foreach($filePathAlternativesArray as $jsonData)
{
	$arrayToAdd[] = $jsonData["value"];
	if($toggle)
	{
		$sortedFilePathAlternativesArray[] = $arrayToAdd;
		$arrayToAdd = [];
	}
	$toggle = !$toggle;
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
			$localSliceSize = $sliceSize;
			if(isset($pathData["sliceSize"]))
			{
				$localSliceSize = $pathData["sliceSize"];
			}
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
						$poll->trimLogLine($filename, $logSizeLimit,$logTrimMacBSD,$buffer, $shellOrPhp, $showErrorPhpFileOpen);
					}
					elseif($logTrimType == 'size') //compair to trimsize value
					{
						$poll->trimLogSize($filename, $logSizeLimit,$logTrimMacBSD,$buffer, $shellOrPhp. $showErrorPhpFileOpen);
					}

					if($lineCountFromJS === "false")
					{
						$lineCount = $poll->getLineCount($filename, $shellOrPhp);
					}
				}
				//poll logic
				if($pathData["GrepFilter"] == "")
				{
					$dataVar =  $poll->tail($filename, $localSliceSize, $shellOrPhp);
				}
				else
				{
					$dataVar = $poll->tailWithGrep($filename, $localSliceSize, $shellOrPhp, $pathData["GrepFilter"]);
				}
			}
			$dataVar = htmlentities($dataVar);
			if($advancedLogFormatEnabled === "true" && $logFormatFileEnable === "true")
			{
				//try and get file path and file lines
				$arrayOfFiles = array();
				$tmpLog = explode(PHP_EOL, $dataVar);
				foreach ($tmpLog as $tmpLogLine)
				{
					//check for line here, add file path to array if there
					preg_match_all('/(in|at) (.?)([\/]+)((([^&\r\n\t:]*)(on line))|(([^&\r\n\t]*)(\D:\d)))(.?)(\d{1,10})/', $tmpLogLine, $matches);
					if(count($matches) > 0)
					{
						foreach($matches as $filePaths)
						{
							if(!isset($filePaths[0]))
							{
								continue;
							}
							foreach($filePaths as $filePath)
							{
								preg_match('/(in|at) (.?)([\/]+)([^&\r\n\t]*)(\D:\d)(.?)(\d{1,10})/', $filePath, $match);
								if(count($match) < 1)
								{
									preg_match('/(in|at) (.?)([\/]+)([^&\r\n\t:]*)(on line)(.?)(\d{1,10})/', $filePath, $match);
								}
								if(count($match) < 1)
								{
									continue;
								}
								if(!isset($arrayOfFiles[$match[0]]))
								{
									$fileData = "Error - File Not Found";
									$fileName = trim($match[3].$match[4]);
									$match[7] = $match[6] . $match[7];
									//this one is on line match
									if(!file_exists($fileName))
									{
										//try one of the alternitive paths
										if(!empty($sortedFilePathAlternativesArray))
										{
											foreach($sortedFilePathAlternativesArray as $pathToTest)
											{
												if(strpos($fileName, $pathToTest[0]) !== false)
												{
													$possibleNewPath = str_replace($pathToTest[0], $pathToTest[1], $fileName);
													if(file_exists($possibleNewPath))
													{
														$fileName = $possibleNewPath;
													}
												}
											}
										}
									}
									if(!file_exists($fileName))
									{
										//this one is \D:\d match
										$lastPartOfFile = explode(":", $match[5]);
										$fileName = trim($match[3].$match[4].$lastPartOfFile[0]);
										if(count($lastPartOfFile) > 1)
										{
											$match[7] = $lastPartOfFile[1].$match[7];
										}
									}
									if(!file_exists($fileName))
									{
										//try one of the alternitive paths
										if(!empty($sortedFilePathAlternativesArray))
										{
											foreach($sortedFilePathAlternativesArray as $pathToTest)
											{
												if(strpos($fileName, $pathToTest[0]) !== false)
												{
													$possibleNewPath = str_replace($pathToTest[0], $pathToTest[1], $fileName);
													if(file_exists($possibleNewPath))
													{
														$fileName = $possibleNewPath;
													}
												}
											}
										}
									}
									if(file_exists($fileName))
									{
										$fileData = "Error - File Not Readable";
										if(is_readable($fileName))
										{
											$linePadding = $logFormatFileLinePadding;
											$totalPading = $linePadding * 2;
											$currentLine = intval($match[7]) - $linePadding;
											if($currentLine < 0)
											{
												$totalPading = $totalPading + $currentLine;
												$currentLine = 0;
											}
											$totalPading++;
											$lineCountLocal = $poll->getLineCount($fileName, $shellOrPhp);
											//check to see if line is greater than file length
											$fileData = "Error - File Changed, line no longer in file";
											if($lineCountLocal >= $currentLine)
											{
												$fileData = $poll->tail($fileName, $totalPading, $shellOrPhp, $currentLine);
											}
										}
									}
									$permissions = "";
									if($logFormatFilePermissions === "always" || ($logFormatFilePermissions === "sometimes" && strpos($fileData, "Permission denied") > -1))
									{
										$permissions = $core->filePermsDisplay($fileName);
									}
									//found a match, add to thing
									$arrayOfFiles[$match[0]] = array(
										"pregMatchData"	=>	$match,
										"fileData"		=>	$fileData,
										"fileName"		=>	$fileName,
										"permissions"	=>	$permissions
									);
								}
							}
						}	
					}
					
				}
				$response[$path]["fileData"] = $arrayOfFiles;
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
			$response[$path]["log"] = "Error - ".$e." ";
			$response[$path]["data"] = " Limit: ".$logSizeLimit."(".($logSizeLimit+$buffer).") ".$modifier." | Line Count: --- | Time: ---";
			$response[$path]["lineCount"] = "---";
		}
	}
}
echo json_encode($response);