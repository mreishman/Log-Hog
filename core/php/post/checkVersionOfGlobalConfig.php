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
$baseUrl = "../../../";

$globalConfig = settingsData::read($baseUrl.'local/conf/globalConfig.json', 'globalConfig');

$globalConfigVersion = 0;
if(isset($globalConfig['globalConfVersion']))
{
	$globalConfigVersion = $globalConfig['globalConfVersion'];
}

$value = false;
if((string)$globalConfigVersion === (string)($_POST['version'] ?? ''))
{
	$value = true;
}
echo json_encode($value);
