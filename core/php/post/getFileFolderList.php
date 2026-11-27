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
$baseModifier = "../../../";
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl = $baseModifier."local/".$currentSelectedTheme."/";
$config = settingsData::read($baseUrl.'conf/config.json', 'config');
$defaultConfig = settingsData::defaults('config');
$globalConfig = settingsData::read($baseModifier.'local/conf/globalConfig.json', 'globalConfig');
$defaultGlobalConfig = settingsData::defaults('globalConfig');

$varsLoadLite = array("watchList");
foreach ($varsLoadLite as $varLoadLite)
{
	$$varLoadLite = $defaultConfig[$varLoadLite];
	if(array_key_exists($varLoadLite, $config))
	{
		$$varLoadLite = $config[$varLoadLite];
	}
}

echo json_encode($watchList);