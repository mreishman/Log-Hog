<?php
require_once("class/core.php");
$core = new core();
require_once("class/session.php");
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
$filter = "$";
$path = $_POST["currentFolder"];
$response = array();
$imageResponse = "defaultRedErrorIcon";
$info = $core->filePermsDisplay($path);
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
		$response = $core->getFileInfoFromDir(
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

echo json_encode(
	array(
		"data" => $response,
		"orgPath" => $_POST["currentFolder"],
		"img" => $imageResponse,
		"fileInfo" => $info
	)
);