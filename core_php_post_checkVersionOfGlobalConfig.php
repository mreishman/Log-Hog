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

require_once($baseUrl.'local/conf/globalConfig.php');

$globalConfigVersion = 0;
if(isset($globalConfig['globalConfigVersion']))
{
	$globalConfigVersion = $globalConfig['globalConfigVersion'];
}

$value = false;
if((string)$configVersion === (string)$_POST['version'])
{
	$value = true;
}
echo json_encode($value);