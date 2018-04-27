<?php
require_once("commonFunctions.php");
$path = $_POST["currentFolder"];
$response = array();
$imageResponse = "defaultRedErrorIcon";
$info = filePermsDisplay($path);
if($path !== "/")
{
	$path = preg_replace('/\/$/', '', $path);
}
if(file_exists($path))
{
	if(is_dir($path))
	{
		$imageResponse = "defaultFolderIcon";
		if(!is_readable($path))
		{
			$imageResponse = "defaultFolderNRIcon";
		}
		elseif(!is_writeable($path))
		{
			$imageResponse = "defaultFolderNWIcon";
		}

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
					$subImg = "defaultFolderIcon";
					if(!is_readable($fullPath))
					{
						$subImg = "defaultFolderNRIcon";
					}
					elseif(!is_writeable($fullPath))
					{
						$subImg = "defaultFolderNWIcon";
					}
					$response[$fullPath] = array(
						"type"		=>	"folder",
						"filename"	=>	$filename,
						"image"		=>	$subImg,
						"fullpath"	=>	$fullPath
					);
				}
				elseif(is_file($fullPath))
				{
					$subImg = "defaultFileIcon";
					if(!is_readable($fullPath))
					{
						$subImg = "defaultFileNRIcon";
					}
					elseif(!is_writeable($fullPath))
					{
						$subImg = "defaultFileNWIcon";
					}
					$response[$fullPath] = array(
						"type"		=>	"file",
						"filename"	=>	$filename,
						"image"		=>	$subImg,
						"fullpath"	=>	$fullPath
					);
				}
			}
		}
	}
	else
	{
		$imageResponse = "defaultFileIcon";
		if(!is_readable($path))
		{
			$imageResponse = "defaultFileNRIcon";
		}
		elseif(!is_writeable($path))
		{
			$imageResponse = "defaultFileNWIcon";
		}
	}
}

echo json_encode(array("data" => $response, "orgPath" => $_POST["currentFolder"], "img" => $imageResponse, "fileInfo" => $info));