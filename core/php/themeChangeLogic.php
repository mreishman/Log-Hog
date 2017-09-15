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
require_once('../../core/conf/config.php');
require_once('../../core/php/configStatic.php');
require_once('../../core/php/loadVars.php');

$directory = "../../core/Themes/".$currentTheme."/";



//Copy over CSS HERE
$scanned_directory = array_diff(scandir($directory."template/"), array('..', '.'));


foreach ($scanned_directory as $key)
{
	copy($directory."template/".$key, $baseUrl."template/".$key);
}

//Copy over Images HERE
$scanned_directory = array_diff(scandir($directory."img/"), array('..', '.'));
foreach ($scanned_directory as $key)
{
	copy($directory."img/".$key, $baseUrl."img/".$key);
}

//Set var to new one here

$themeVersion = $defaultConfig['themeVersion'];

$fileName = ''.$baseUrl.'conf/config.php';
$cssVersion = $cssVersion + 1;

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

echo json_encode(true);
?>