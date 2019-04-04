<?php
require_once("../../core/php/commonFunctions.php");
require_once("../../core/php/class/core.php");
$core = new core();
$baseUrl = "../../local/";
require_once($baseUrl."layout.php");
$baseUrl .= $currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");

if(is_dir('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once('../../core/Themes/'.$currentTheme."/defaultSetting.php");
}

require_once('loadVars.php');

$fileName = $baseUrl.'Themes/Custom-Theme-'.$_POST["themeNumber"].'/defaultSetting.php';

	//Don't forget to update Normal version

	$newInfoForConfig = "<?php
		$"."themeDefaultSettings = array(
		";
	foreach ($themeDefaultSettings as $key => $value)
	{
		$newInfoForConfig .= $core->putIntoCorrectFormat($key, $$key, $value);
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
exit();