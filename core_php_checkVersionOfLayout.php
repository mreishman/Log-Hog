<?php
require_once("class/core.php");
$core = new core();
require_once("class/session.php");
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
require_once('../../local/conf/globalConfig.php');
require_once('../../core/conf/globalConfig.php');

$layoutVersion = 0;
if(isset($globalConfig['layoutVersion']))
{
	$layoutVersion = $globalConfig['layoutVersion'];
}

$value = false;
if((string)$layoutVersion === (string)$_POST['version'])
{
	$value = true;
}
echo json_encode($value);