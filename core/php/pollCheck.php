<?php
$baseModifier = "../../";
require_once($baseModifier.'local/layout.php');
$baseUrl = $baseModifier."local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('configStatic.php');
require_once('updateProgressFile.php');
require_once('commonFunctions.php');
$response = array();
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

function sizeFilesInDir($path, $filter, $response)
{
	$path = preg_replace('/\/$/', '', $path);
	if(file_exists($path))
	{
		$scannedDir = scandir($path);
		if(!is_array($scannedDir))
		{
			$scannedDir = array($scannedDir);
		}
		$files = array_diff($scannedDir, array('..', '.'));
		if($files)
		{
			foreach($files as $k => $filename)
			{
				$fullPath = $path . DIRECTORY_SEPARATOR . $filename;
				if(is_dir($fullPath))
				{
					//$response = sizeFilesInDir($path, $filter, $response);
				}
				elseif(preg_match('/' . $filter . '/S', $filename) && is_file($fullPath))
				{
					$response[$fullPath] = getFileSize($fullPath);
				}
			}
		}
	}
	return $response;
}

foreach($config['watchList'] as $path => $filter)
{
	if(is_dir($path))
	{
		$response = sizeFilesInDir($path, $filter, $response);
	}
	elseif(file_exists($path))
	{
		$response[$path] = getFileSize($path);
	}
}

echo json_encode($response);
exit();