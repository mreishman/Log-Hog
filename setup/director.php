<?php

require_once('setupProcessFile.php');
require_once('../core/php/class/core.php');
$core = new core();

if($setupProcess == "preStart")
{
	$partOfUrl = $core->clean_url($_SERVER['REQUEST_URI']);
	$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
	$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/welcome.php";
	header('Location: ' . $url, true, 301);
	exit();
}

if ($setupProcess == "finished")
{
	$partOfUrl = $core->clean_url($_SERVER['REQUEST_URI']);
	$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
		$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."index.php";
	header('Location: ' . $url, true, 301);
	exit();
}

$partOfUrl = $core->clean_url($_SERVER['REQUEST_URI']);
$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/".$setupProcess.".php";
header('Location: ' . $url, true, 301);
exit();