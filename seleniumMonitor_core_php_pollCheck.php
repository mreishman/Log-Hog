<?php
require_once('../../local/layout.php');
$baseUrl = "../../local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../../core/php/configStatic.php');
require_once('../../core/php/updateProgressFile.php');

function tail($filename)
{
	$filename = preg_replace('/([()"])/S', '$1', $filename);
	return filesize($filename);
}

if($configStatic['version'] != $_POST['currentVersion'])
{
	$response = false;
}
elseif(array_key_exists('percent', $updateProgress) && ($updateProgress['percent'] != 0) && $updateProgress['percent'] != 100)
{
	$response = "update in progress";
}
else
{
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
						$response[$fullPath] = htmlentities(tail($fullPath));
					}
				}
			}
		}
		elseif(file_exists($path))
		{
			$response[$path] = htmlentities(tail($path));
		}
	}
}

echo json_encode($response);