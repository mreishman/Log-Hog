<?php

require_once('setupProcessFile.php');
function clean_url($url) {
    $parts = parse_url($url);
    return $parts['path'];
}

if($setupProcess == "preStart")
{
	$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
	$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
	$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/welcome.php";
	header('Location: ' . $url, true, 301);
	exit();
}
elseif ($setupProcess == "finished")
{
	$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
	$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
		$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."index.php";
	header('Location: ' . $url, true, 301);
	exit();
}
else
{
	$partOfUrl = clean_url($_SERVER['REQUEST_URI']);
	$partOfUrl = substr($partOfUrl, 0, strpos($partOfUrl, 'setup'));
	$url = "http://" . $_SERVER['HTTP_HOST'] .$partOfUrl ."setup/".$setupProcess.".php";
	header('Location: ' . $url, true, 301);
	exit();
}

?>