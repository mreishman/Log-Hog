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
require_once('../../../core/conf/config.php');
require_once('../../../core/php/configStatic.php');
require_once('../../../core/php/loadVars.php');

$configVersion = $_POST['version'];

$fileName = ''.$baseUrl.'conf/config.php';

$newInfoForConfig = "<?php
	$"."config = array(
	";
foreach ($defaultConfig as $key => $value)
{
	if(is_string($value))
	{
		$newInfoForConfig .= "
		'".$key."' => '".$$key."',
	";
	}
	elseif(is_array($value))
	{
		$newInfoForConfig .= "
		'".$key."' => array(".$$key."),
	";
	}
	else
	{
		$newInfoForConfig .= "
		'".$key."' => ".$$key.",
	";
	}
}
$newInfoForConfig .= "
	);
?>";

file_put_contents($fileName, $newInfoForConfig);

echo json_encode($_POST['version']);