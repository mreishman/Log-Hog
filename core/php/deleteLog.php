<?php
$verifyFile = $_POST['file'];
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
					if($verifyFile == $fullPath){
						unlink($_POST['file']);
						break;
					}
				}
			}
		}
	}
	elseif(file_exists($path)){
		if($path == $verifyFile){
			unlink($_POST['file']);
			break;
		}
	}
}
echo json_encode($_POST['file']);