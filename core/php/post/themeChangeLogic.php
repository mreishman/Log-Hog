<?php
require_once("../class/core.php");
$core = new core();
require_once("../class/session.php");
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
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl = "../../../local/".$currentSelectedTheme."/";
$settingsLock = settingsData::lock($baseUrl."conf");
$config = settingsData::read($baseUrl.'conf/config.json', 'config');
$defaultConfig = settingsData::defaults('config');
$globalConfig = settingsData::read('../../../local/conf/globalConfig.json', 'globalConfig');
$defaultGlobalConfig = settingsData::defaults('globalConfig');
require_once('../../../core/php/configStatic.php');
//get current selected theme directory and settings
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
$directory = "../../../core/Themes/".$currentTheme."/";
if(is_dir('../../../local/Themes/'.$currentTheme))
{
	$directory = "../../../local/Themes/".$currentTheme."/";
}
$themeDefaultSettings = settingsData::read($directory."defaultSetting.json", 'themeDefaultSettings');
require_once('../../../core/php/loadVars.php');
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
$fileName = ''.$baseUrl.'conf/config.json';
$cssVersion = $cssVersion + 1;
$newInfoForConfig = [];
foreach ($defaultConfig as $key => $value)
{
	if(
		$$key !== $defaultConfig[$key] &&
		(
			!isset($themeDefaultSettings) ||
			isset($themeDefaultSettings) && !array_key_exists($key, $themeDefaultSettings) ||
			isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings) && $themeDefaultSettings[$key] !== $$key
		)
		||
		$$key === $defaultConfig[$key] && isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings) && $themeDefaultSettings[$key] !== $$key
		||
		isset($arrayOfCustomConfig[$key])
	)
	{
		$newInfoForConfig[$key] = $$key;
	}
}


echo json_encode(settingsData::write($fileName, $newInfoForConfig) ? true : 5);
