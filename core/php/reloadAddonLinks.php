<?php
require_once("../../core/php/class/session.php");
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
require_once("../../core/php/class/core.php");
$core = new core();
require_once("../../core/php/class/addons.php");
$addons = new addons();
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl = "../../local/".$currentSelectedTheme."/";
$localURL = $baseUrl;
require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
require_once('../../local/conf/globalConfig.php');
require_once('../../core/conf/globalConfig.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../../core/Themes/'.$currentTheme."/defaultSetting.php");
}
require_once('../../core/php/loadVars.php');
$locationForStatusIndex = $addons->checkForStatusInstall($locationForStatus, "./");
$locationForMonitorIndex = $addons->checkForMonitorInstall($locationForMonitor, "./");
$locationForSearchIndex = $addons->checkForSearchInstall($locationForSearch, "./");
$locationForSeleniumMonitorIndex = $addons->checkForSeleniumMonitorInstall($locationForSeleniumMonitor, "./");
require_once("template/addonLinksSideBar.php");
?>