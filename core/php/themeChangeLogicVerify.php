<?php
require_once("../../core/php/commonFunctions.php");
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

$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	$directory = "../../local/".$currentSelectedTheme."/Themes/".$currentTheme."/";
	require_once('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	$directory = "../../core/Themes/".$currentTheme."/";
	require_once('../../core/Themes/'.$currentTheme."/defaultSetting.php");
}

require_once('../../core/php/loadVars.php');


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