<?php
require_once("../class/core.php");
$core = new core();
require_once("../class/upgrade.php");
$upgrade = new upgrade();
$baseBaseUrl = $core->baseURL();
$baseUrl = $baseBaseUrl."local/";
$currentSelectedTheme = $upgrade->getCurrentSelectedTheme();
$baseUrl .= $currentSelectedTheme."/";
$config = settingsData::read($baseUrl.'conf/config.json', 'config');
$defaultConfig = settingsData::defaults('config');
$watchlist = $defaultConfig["watchList"];
$arrayForNewStuff = array(
	"configVersion" => (Int)$_POST['version']
);

if (!isset($config["moduleDisabledList"]))
{
	$modulesList = array(
		"themesEnabled",
		"enableMultiLog",
		"enableHistory",
		"oneLogEnable",
		"filterEnabled",
		"rightClickMenuEnable",
		"advancedLogFormatEnabled",
		"backupNumConfigEnabled",
		"updaterEnabled"
	);
	$disabledModules = [];
	foreach($modulesList as $module)
	{
		if(isset($config[$module]))
		{
			$disabledModules[] = $module;
		}
	}
	$arrayForNewStuff["moduleDisabledList"] = json_encode($disabledModules);
}

$upgrade->upgradeConfig($arrayForNewStuff);
echo json_encode($_POST['version']);