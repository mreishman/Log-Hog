<?php
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
$baseUrl = "../../core/";
if(file_exists('../../local/layout.php'))
{
	$baseUrl = "../../local/";
	//there is custom information, use this
	require_once('../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');

$layoutVersion = 0;
if(isset($config['layoutVersion']))
{
	$layoutVersion = $config['layoutVersion'];
}

$value = false;
if((string)$layoutVersion === (string)$_POST['version'])
{
	$value = true;
}
echo json_encode($value);