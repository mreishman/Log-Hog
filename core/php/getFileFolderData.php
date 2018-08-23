<?php
require_once("commonFunctions.php");

$filter = "$";

function getFileInfoFromDir($data, $response)
{
	$path = $data["path"];
	$recursive = $data["recursive"];
	$filter = $data["filter"];
	if(!is_readable($path))
	{
		return $response;
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
				if($recursive === "true")
				{
					$response = getFileInfoFromDir(
						array(
							"path"		=>	$fullPath,
							"recursive"	=>	$recursive
						),
						$response
					);
				}
			}
			elseif(preg_match('/' . $filter . '/S', $filename) && is_file($fullPath))
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
	return $response;
}

$path = $_POST["currentFolder"];
$response = array();
$imageResponse = "defaultRedErrorIcon";
$info = filePermsDisplay($path);
$recursive = false;
if(isset($_POST["filter"]))
{
	$filter = $_POST["filter"];
}
if(isset($_POST["recursive"]))
{
	$recursive = $_POST["recursive"];
}
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
		$response = getFileInfoFromDir(
			array(
				"path"			=>	$path,
				"recursive"		=>	$recursive,
				"filter"		=>	$filter
			),
			$response
		);
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