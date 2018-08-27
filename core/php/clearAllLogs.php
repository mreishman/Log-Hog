<?php
require_once('../../local/layout.php');
$baseUrl = "../../local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');

foreach($config['watchList'] as $value){
	$path = $value["Location"];
	$filter = $value["Pattern"];
	if(is_dir($path)){
		$path = preg_replace('/\/$/', '', $path);
		$files = scandir($path);
		if($files) {
			unset($files[0], $files[1]);
			foreach($files as $k => $filename) {
				$fullPath = $path . '/' . $filename;
				if(preg_match('/' . $filter . '/S', $filename) && is_file($fullPath)){
					$command = "truncate -s 0 ".$fullPath;
					shell_exec($command);
				}
			}
		}
	}
	elseif(file_exists($path)){
		$command = "truncate -s 0 ".$path;
		shell_exec($command);
	}
}