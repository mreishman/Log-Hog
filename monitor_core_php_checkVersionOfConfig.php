<?php
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
?>