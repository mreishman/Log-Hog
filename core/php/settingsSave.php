<?php

$baseUrl = "../../core/";
if(file_exists('../../local/layout.php'))
{
	$baseUrl = "../../local/";
	//there is custom information, use this
	require_once('../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}

if(file_exists($baseUrl.'conf/config.php'))
{
	require_once($baseUrl.'conf/config.php');
}
else
{
	$config = array();
}
require_once('../../core/conf/config.php');
require_once('loadVars.php');


	$fileName = ''.$baseUrl.'conf/config.php';

	//Don't forget to update Ajax version

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

	//Don't forget to update Ajax version

	file_put_contents($fileName, $newInfoForConfig);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
?>