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

$settingsLock = settingsData::lock("../../../local/conf");
$config = array();
if(settingsData::exists($baseUrl.'conf/config.json'))
{
	$config = settingsData::read($baseUrl.'conf/config.json', 'config');
	// Ok if it doesn't exist, user might have deleted to reset settings or something?
}

$globalConfig = array();
if(settingsData::exists('../../../local/conf/globalConfig.json'))
{
	$globalConfig = settingsData::read('../../../local/conf/globalConfig.json', 'globalConfig');
	// Ok if it doesn't exist, user might have deleted to reset settings or something?
}

if (!file_exists("../../../core/conf/globalConfig.php") || !is_readable("../../../core/conf/globalConfig.php"))
{
	echo json_encode(8);
	exit();
}
$defaultGlobalConfig = settingsData::defaults('globalConfig');
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
    && !settingsData::backup("../../../local/conf/globalConfig", 'globalConfig', $backupNumConfig))
{
	echo json_encode(6);
	exit();
}

$fileName = '../../../local/conf/globalConfig.json';

$newInfoForConfig = [];
foreach ($defaultGlobalConfig as $key => $value)
{
	$newInfoForConfig[$key] = $$key;
}


echo json_encode(settingsData::write($fileName, $newInfoForConfig) ? true : 5);
