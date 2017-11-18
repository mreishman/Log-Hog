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
$boolToReturn = true;
foreach ($scanned_directory as $key)
{
	if(!is_file($baseUrl."template/".$key))
	{
		$boolToReturn = false;
	}
}

//Copy over Images HERE
$scanned_directory = array_diff(scandir($directory."img/"), array('..', '.'));
foreach ($scanned_directory as $key)
{
	if(!is_file($baseUrl."img/".$key))
	{
		$boolToReturn = false;
	}
}

//check if version in current css is equal to default

if($config['themeVersion'] !== $defaultConfig['themeVersion'])
{
	$boolToReturn = false;
}

echo json_encode($boolToReturn);
?>