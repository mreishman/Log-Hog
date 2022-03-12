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
$type = "none";
if(file_exists($path))
{
	$type = "File";
	if(is_dir($path))
	{
		$type = "Folder";
		$response = $core->getFileInfoFromDir(
			array(
				"path"			=>	$path,
				"recursive"		=>	$recursive,
				"filter"		=>	$filter
			),
			$response
		);
	}

	$imageResponse = "default".$type."Icon";
	if(!is_readable($path))
	{
		$imageResponse = "default".$type."NRIcon";
	}
	elseif(!is_writeable($path))
	{
		$imageResponse = "default".$type."NWIcon";
	}
}

echo json_encode(
	array(
		"data" => $response,
		"orgPath" => $_POST["currentFolder"],
		"img" => $imageResponse,
		"type" => strtolower($type),
		"fileInfo" => $info
	)
);