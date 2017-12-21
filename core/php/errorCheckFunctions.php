<?php

function testErrorBase()
{
	$tmpFuncBaseURL = "";
	$boolTestBaseURL = file_exists($tmpFuncBaseURL."error.php");
	while(!$boolTestBaseURL)
	{
		$tmpFuncBaseURL .= "../";
		$boolTestBaseURL = file_exists($tmpFuncBaseURL."error.php");
	}
	return $tmpFuncBaseURL;
}

function checkIfFilesAreReadable($arrayOfFiles, $urlPath, $currentFile)
{
	$checkIfFilesAreReadableBaseUrl = testErrorBase();
	foreach ($arrayOfFiles as $file)
	{
		if(!is_readable($checkIfFilesAreReadableBaseUrl.$file))
		{
			echoErrorJavaScript($urlPath, $file." could not be read from ".$currentFile, 1072);
		}
	}
}

function checkIfFilesAreWritable($arrayOfFiles, $urlPath, $currentFile)
{
	$checkIfFilesAreWritableBaseUrl = testErrorBase();
	foreach ($arrayOfFiles as $file)
	{
		if(!is_writable($checkIfFilesAreWritableBaseUrl.$file))
		{
			echoErrorJavaScript($urlPath, $file." could not be written to from ".$currentFile, 1073);
		}
	}
}

function checkIfFilesExist($arrayOfFiles, $urlPath, $currentFile)
{
	$checkIfFilesAreThereBaseUrl = testErrorBase();
	foreach ($arrayOfFiles as $file)
	{
		if(!file_exists($checkIfFilesAreThereBaseUrl.$file))
		{
			fileMissingError($file, $urlPath, $currentFile);
		}
	}
}

function configFileErrorChecks($config, $urlPath, $currentFile)
{
	foreach($config['watchList'] as $key => $item)
	{
		if(is_array($item))
		{
			break;
		}
		if(strpos($item, "\\") !== false)
		{
			echoErrorJavaScript($urlPath, "Local/.../Config::Watchlist", 1);
		}
	}
}

function fileMissingError($file, $urlPath, $currentFile)
{
	echoErrorJavaScript($urlPath, $file." is not accessable from ".$currentFile, 1074);
}

function throwSetupError($urlPath)
{
	echoErrorJavaScript($urlPath, "An error occured durring setup", 2);
}

function echoErrorJavaScript($urlPath, $mainMessage, $errorNumber)
{
	$urlPath = $urlPath."error.php?error=".$errorNumber."&page=".$mainMessage;
	echo "<script type=\"text/javascript\"> window.location.href = '".$urlPath."'; </script>";
	exit();
}