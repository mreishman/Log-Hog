<?php
require_once("class/core.php");
$core = new core();
require_once("class/session.php");
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
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl = "../../local/".$currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
require_once('../../local/conf/globalConfig.php');
require_once('../../core/conf/globalConfig.php');
require_once('../../core/php/configStatic.php');
//get current selected theme directory and settings
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
$directory = "../../core/Themes/".$currentTheme."/";
if(is_dir('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	$directory = "../../local/".$currentSelectedTheme."/Themes/".$currentTheme."/";
}
require_once($directory."defaultSetting.php");
require_once('../../core/php/loadVars.php');
//Copy over CSS HERE
$scanned_directory = array_diff(scandir($directory."template/"), array('..', '.'));
foreach ($scanned_directory as $key)
{
	copy($directory."template/".$key, $baseUrl."template/".$key);
}
//Copy over Images HERE
$scanned_directory = array_diff(scandir($directory."img/"), array('..', '.'));
foreach ($scanned_directory as $key)
{
	copy($directory."img/".$key, $baseUrl."img/".$key);
}
//Set var to new one here
$themeVersion = $defaultConfig['themeVersion'];
$fileName = ''.$baseUrl.'conf/config.php';
$cssVersion = $cssVersion + 1;
$newInfoForConfig = "<?php
	$"."config = array(
	";
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
		$newInfoForConfig .= $core->putIntoCorrectFormat($key, $$key, $value);
	}
}
$newInfoForConfig .= "
	);
?>";

if(file_exists($fileName))
{
	unlink($fileName);
}

file_put_contents($fileName, $newInfoForConfig);
echo json_encode(true);