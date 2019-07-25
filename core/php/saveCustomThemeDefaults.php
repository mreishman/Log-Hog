<?php
require_once("class/session.php");
$session = new session();
if(!$session->startSession())
{
	echo json_encode(array("error" => 14));
	exit();
}
require_once("../../core/php/class/core.php");
$core = new core();
$baseUrl = "../../local/";
require_once($baseUrl."layout.php");
$baseUrl .= $currentSelectedTheme."/";
require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");

$requireFile = "../../core/Themes/".$currentTheme."/defaultSetting.php";
if(is_dir("../../local/".$currentSelectedTheme."/Themes/".$currentTheme))
{
	$requireFile = "../../local/".$currentSelectedTheme."/Themes/".$currentTheme."/defaultSetting.php";
}
require_once($requireFile);


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