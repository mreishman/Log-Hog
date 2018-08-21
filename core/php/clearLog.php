<?php
$verifyFile = $_POST['file'];
$baseUrl = "../../core/";
if(file_exists('../../local/layout.php'))
{
	$baseUrl = "../../local/";
	//there is custom information, use this
	require_once('../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
require_once('../../core/php/configStatic.php');

foreach($config['watchList'] as $path => $filter)
{
	if(is_dir($path))
	{
		//folder
		$path = preg_replace('/\/$/', '', $path);
		$files = scandir($path);
		if($files) {
			unset($files[0], $files[1]);
			foreach($files as $k => $filename) {
				$fullPath = $path . '/' . $filename;
				if(preg_match('/' . $filter . '/S', $filename) && is_file($fullPath))
				{
					if($verifyFile === $fullPath)
					{
						$command = "truncate -s 0 ".$fullPath;
						shell_exec($command);
						break;
					}
				}
			}
		}
	}
	elseif(file_exists($path))
	{
		if($path === $verifyFile)
		{
			$command = "truncate -s 0 ".$path;
			shell_exec($command);
			break;
		}
	}
}