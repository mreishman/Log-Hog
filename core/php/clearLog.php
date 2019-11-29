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
$verifyFile = false;
if(isset($_POST['file']))
{
	$verifyFile = trim($_POST['file']);
}
$type = trim($_POST['type']);
$returnData = array(
	"success"	=> "false",
	"file"		=>	$verifyFile,
	"fileFound"	=>	"false"
);
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl = "../../local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
$command = "";
foreach($config['watchList'] as $value){
	$path = $value["Location"];
	$filter = $value["Pattern"];
	if(is_dir($path))
	{
		$path = preg_replace('/\/$/', '', $path);
		$files = scandir($path);
		if($files)
		{
			unset($files[0], $files[1]);
			foreach($files as $k => $filename)
			{
				$fullPath = $path . '/' . $filename;
				if(preg_match('/' . $filter . '/S', $filename) && is_file($fullPath))
				{
					if($verifyFile == $fullPath || $type === "clearAllLogs")
					{
						$returnData["fileFound"] = "true";
						if($type === "deleteLog")
						{
							unlink($fullPath);
						}
						else
						{
							$command = "truncate -s 0 ".$fullPath;
							shell_exec($command);
						}
						$returnData["success"] = "true";
						if($type !== "clearAllLogs")
						{
							break;
						}
					}
				}
			}
		}
	}
	elseif(file_exists($path))
	{
		if($path == $verifyFile || $type === "clearAllLogs")
		{
			$returnData["fileFound"] = "true";
			if($type === "deleteLog")
			{
				unlink($fullPath);
			}
			else
			{
				$command = "truncate -s 0 ".$path;
				shell_exec($command);
			}
			$returnData["success"] = "true";
			if($type !== "clearAllLogs")
			{
				break;
			}
		}
	}
}
echo json_encode($returnData);