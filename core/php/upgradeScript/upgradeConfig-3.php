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

if (isset($config['watchList']) && is_array($config['watchList']))
{
	$watchList = [];
	foreach ($config['watchList'] as $key => $value)
	{
		$defaults = $defaultConfig['watchList']['HHVM'];
		if (is_array($value))
		{
			$watchList[$key] = array_replace($defaults, $value);
		}
		else
		{
			$watchList[$key] = array_replace($defaults, [
				'FileType' => 'auto', 'Location' => (string)$key, 'Pattern' => (string)$value,
			]);
		}
	}
	$arrayForNewStuff['watchList'] = $watchList;
}
$arrayForNewStuff['popupSettingsArray'] = '{"saveSettings":"true","blankFolder":"true","deleteLog":"true","removeFolder":"true","versionCheck":"true"}';
$upgrade->upgradeConfig($arrayForNewStuff);
echo json_encode($_POST['version']);