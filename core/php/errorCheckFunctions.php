<?php

function checkIfFilesAreReadable($arrayOfFiles, $urlPath)
{
	$checkIfFilesAreReadableBaseUrl = baseURL();
	foreach ($arrayOfFiles as $file)
	{
		if(!file_exists($checkIfFilesAreReadableBaseUrl.$file) || !is_readable($checkIfFilesAreReadableBaseUrl.$file))
		{
			echoErrorJavaScript($urlPath, $file, 1072);
		}
	}
}

function checkIfFilesAreWritable($arrayOfFiles, $urlPath)
{
	$checkIfFilesAreWritableBaseUrl = baseURL();
	foreach ($arrayOfFiles as $file)
	{
		if(!file_exists($checkIfFilesAreWritableBaseUrl.$file) || !is_writable($checkIfFilesAreWritableBaseUrl.$file))
		{
			echoErrorJavaScript($urlPath, $file, 1073);
		}
	}
}

function configFileErrorChecks($config, $urlPath)
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

function echoErrorJavaScript($urlPath, $file, $errorNumber)
{
	$urlPath = $urlPath."error.php?error=".$errorNumber."&page=".$file;
	echo "<script type=\"text/javascript\"> window.location.href = '".$urlPath."'; </script>";
	exit();
}