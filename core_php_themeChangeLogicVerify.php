<?php
require_once("../../core/php/commonFunctions.php");
require_once('../../local/layout.php');
$baseUrl = "../../local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
require_once('../../core/php/configStatic.php');
//get current selected theme directory and settings
$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
$directory = "../../core/Themes/".$currentTheme."/";
if(is_dir('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	$directory = "../../local/".$currentSelectedTheme."/Themes/".$currentTheme."/";
}
require_once($directory."defaultSetting.php");
require_once('../../core/php/loadVars.php');
$boolToReturn = true;
//check if version in current css is equal to default
if($config['themeVersion'] !== $defaultConfig['themeVersion'])
{
	$boolToReturn = false;
}
if($boolToReturn)
{
	//Verify Images HERE
	$scanned_directory = array_diff(scandir($directory."img/"), array('..', '.'));
	foreach ($scanned_directory as $key)
	{
		if(!is_file($baseUrl."img/".$key))
		{
			$boolToReturn = false;
			break;
		}
	}
	if($boolToReturn)
	{
		//Verify CSS HERE
		$scanned_directory = array_diff(scandir($directory."template/"), array('..', '.'));
		foreach ($scanned_directory as $key)
		{
			if(!is_file($baseUrl."template/".$key))
			{
				$boolToReturn = false;
				break;
			}
		}
	}
}
echo json_encode($boolToReturn);