<?php

$path = $_POST["currentFolder"];
$response = array();

if($path !== "/")
{
	$path = preg_replace('/\/$/', '', $path);
}
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
			$fullPath = $path;
			if($path != "/")
			{
				$fullPath .= DIRECTORY_SEPARATOR;
			}
			$fullPath .= $filename;
			if(is_dir($fullPath))
			{
				$response[$fullPath] = array(
					"type"		=>	"folder",
					"filename"	=>	$filename
				);
			}
			elseif(is_file($fullPath))
			{
				$response[$fullPath] = array(
					"type"	=>	"file",
					"filename"	=>	$filename
				);
			}
		}
	}
}
echo json_encode(array("data" => $response, "orgPath" => $_POST["currentFolder"]));