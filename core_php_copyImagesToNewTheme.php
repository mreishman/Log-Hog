<?php
require_once("../../core/php/class/core.php");
$core = new core();
$baseUrl = "../../local/";
require_once($baseUrl."layout.php");
$baseUrl .= $currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
$directory = '../../core/Themes/'.$currentTheme.'/';
if(is_dir('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	$directory = '../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme.'/';
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