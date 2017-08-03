<?php
require_once('../../local/layout.php');
$baseUrl = "../../local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../../core/php/configStatic.php');

function tail($filename) 
{
	$filename = preg_replace('/([()"])/S', '$1', $filename);
	return filesize($filename);
}

$response = array();

foreach($config['watchList'] as $path => $filter) 
{
	if(is_dir($path)) 
	{
		$path = preg_replace('/\/$/', '', $path);
		$files = scandir($path);
		if($files) 
		{
			unset($files[0], $files[1]);
			foreach($files as $k => $filename) {
				$fullPath = $path . '/' . $filename;
				if(preg_match('/' . $filter . '/S', $filename) && is_file($fullPath))
				{
					$dataVar = htmlentities(tail($fullPath));
					$response[$fullPath] = $dataVar;
				}
			}
		}
	}
	elseif(file_exists($path))
	{
		$dataVar =  htmlentities(tail($path));
		$response[$path] = $dataVar;
	}
}
echo json_encode($response);