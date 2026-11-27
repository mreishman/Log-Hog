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
$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."error.php"))
{
  $varToIndexDir .= "../";
  $countOfSlash++;
}
$baseUrl = $varToIndexDir."local/";
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl .= $currentSelectedTheme."/";

$config = array();
if(settingsData::exists($baseUrl.'conf/config.json'))
{
	$config = settingsData::read($baseUrl.'conf/config.json', 'config');
}
$defaultConfig = settingsData::defaults('config');

$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir($varToIndexDir.'local/Themes/'.$currentTheme))
{
	$themeDefaultSettings = settingsData::read($varToIndexDir.'local/Themes/'.$currentTheme."/defaultSetting.json", 'themeDefaultSettings');
}
else
{
	$themeDefaultSettings = settingsData::read($varToIndexDir.'core/Themes/'.$currentTheme."/defaultSetting.json", 'themeDefaultSettings');
}

$submitted = settingsData::structuredInput($_POST, $defaultConfig);
foreach ($defaultConfig as $key => $value)
{
	if (isset($_POST[$key]) && !is_array($value))
	{
		$submitted[$key] = settingsData::input($_POST[$key], $value, $key);
	}
}

foreach ($submitted as $key => $value)
{
	$current = $config[$key] ?? $themeDefaultSettings[$key] ?? $defaultConfig[$key];
	if ($value != $current)
	{
		echo json_encode(false);
		exit();
	}
}

echo json_encode(true);
