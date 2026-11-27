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

$baseUrl = "../../../local/";
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl .= $currentSelectedTheme."/";

$config = settingsData::read($baseUrl.'conf/config.json', 'config');

$configVersion = 0;
if(isset($config['configVersion']))
{
	$configVersion = $config['configVersion'];
}

$value = false;
if((string)$configVersion === (string)$_POST['version'])
{
	$value = true;
}
echo json_encode($value);