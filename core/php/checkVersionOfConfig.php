<?php
require_once("class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
$baseUrl = "../../core/";
if(file_exists('../../local/layout.php'))
{
	$baseUrl = "../../local/";
	//there is custom information, use this
	require_once('../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');

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