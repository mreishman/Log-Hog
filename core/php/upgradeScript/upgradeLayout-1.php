<?php

$baseDir = "../../../local/";
if(!file_exists($baseDir."profiles/")) {
	mkdir($baseDir."profiles/",0777, true);
}
$scanned_directory = array_diff(scandir($baseDir), array('..', '.','conf','profiles','themes'));

foreach ($scanned_directory as $key) {
	if(is_dir($baseDir . $key)) {
		rename($baseDir . $key, $baseDir . "profiles/" . $key);
	}
}
require_once("../class/core.php");
$core = new core();
require_once("../class/upgrade.php");
$upgrade = new upgrade();
$upgrade->globalConfig(array("layoutVersion" => 1));
echo json_encode($_POST['version']);