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
$baseUrl = "../../../local/";
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl .= $currentSelectedTheme."/";
$config = settingsData::read($baseUrl.'conf/config.json', 'config');
$defaultConfig = settingsData::defaults('config');
$globalConfig = settingsData::read('../../../local/conf/globalConfig.json', 'globalConfig');
$defaultGlobalConfig = settingsData::defaults('globalConfig');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");

$requireFile = "../../../core/Themes/".$currentTheme."/defaultSetting.json";
if(is_dir("../../../local/Themes/".$currentTheme))
{
	$requireFile = "../../../local/Themes/".$currentTheme."/defaultSetting.json";
}
$themeDefaultSettings = settingsData::read($requireFile, 'themeDefaultSettings');
require_once('../loadVars.php');

$themeNumber = settingsData::input($_POST["themeNumber"] ?? null, 0);
if ($themeNumber < 1) {
    echo json_encode(5);
    exit();
}
$fileName = '../../../local/Themes/Custom-Theme-'.$themeNumber.'/defaultSetting.json';

$newInfoForConfig = [];
foreach ($themeDefaultSettings as $key => $value)
{
	$newInfoForConfig[$key] = $$key ?? $value;
}

echo json_encode(settingsData::write($fileName, $newInfoForConfig) ? true : 5);
