<?php

$baseUrl = "../../../core/";
if(file_exists('../../../local/layout.php'))
{
	$baseUrl = "../../../local/";
	//there is custom information, use this
	require_once('../../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');

$layoutVersion = 0;
if(isset($config['layoutVersion']))
{
	$layoutVersion = $config['layoutVersion'];
}


$value = false;
if($layoutVersion === $POST['version'])
{
	$value = true;
}
echo json_encode($value);
?>