<?php
require_once("../../core/php/class/core.php");
$core = new core();
require_once("../../core/php/class/session.php");
$session = new session();
$baseUrl = "../../local/";
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl .= $currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
require_once('../../core/conf/globalConfig.php');
require_once('../../local/conf/globalConfig.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
$directory = '../../core/Themes/'.$currentTheme.'/';
if(is_dir('../../local/Themes/'.$currentTheme))
{
	$directory = '../../local/Themes/'.$currentTheme.'/';
}
require_once($directory."defaultSetting.php");
require_once('loadVars.php');
//Copy over CSS HERE
$scanned_directory = array_diff(scandir($directory."template/"), array('..', '.'));
foreach ($scanned_directory as $key)
{
	copy($directory."template/".$key, $baseUrl."Themes/Custom-Theme-".$_POST['themeNumber']."/template/".$key);
}
//Copy over Images HERE
$scanned_directory = array_diff(scandir($directory."img/"), array('..', '.'));
foreach ($scanned_directory as $key)
{
	copy($directory."img/".$key, $baseUrl."Themes/Custom-Theme-".$_POST['themeNumber']."/img/".$key);
}
echo json_encode(true);
exit();