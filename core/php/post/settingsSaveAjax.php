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
require_once("../../../core/php/class/core.php");
$core = new core();
$baseUrl = "../../../local/";
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl .= $currentSelectedTheme."/";
$settingsLock = settingsData::lock($baseUrl."conf");

$config = array();
if(settingsData::exists($baseUrl.'conf/config.json'))
{
	$config = settingsData::read($baseUrl.'conf/config.json', 'config');
	// Ok if it doesn't exist, user might have deleted to reset settings or something?
}

if (!file_exists("../../../core/conf/config.php") || !is_readable("../../../core/conf/config.php"))
{
	echo json_encode(8);
	exit();
}
$defaultConfig = settingsData::defaults('config');

if(!isset($defaultConfig))
{
	echo json_encode(10);
	exit();
}

$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
$requireFile = "../../../core/Themes/".$currentTheme."/defaultSetting.json";
if(is_dir("../../../local/Themes/".$currentTheme))
{
	$requireFile = "../../../local/Themes/".$currentTheme."/defaultSetting.json";
}
$themeDefaultSettings = settingsData::read($requireFile, 'themeDefaultSettings');

require_once('../loadVars.php');
if (!in_array('backupNumConfigEnabled', $arrayOfDisabledModules)
    && !settingsData::backup($baseUrl."conf/config", 'config', $backupNumConfig))
{
	echo json_encode(6);
	exit();
}

$fileName = ''.$baseUrl.'conf/config.json';

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


if(is_writable($baseUrl."conf/"))
{
	if(file_exists($fileName) && !is_writable($fileName))
	{
		echo json_encode(4);
		exit();
	}
	if (!settingsData::write($fileName, $newInfoForConfig))
	{
		echo json_encode(5);
		exit();
	}

	echo json_encode(true);
	exit();
}
echo json_encode(3);
exit();
