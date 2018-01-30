<?php
require_once("../../core/php/commonFunctions.php");
$baseUrl = "../../core/";
if(file_exists('../../local/layout.php'))
{
	$baseUrl = "../../local/";
	//there is custom information, use this
	require_once('../../local/layout.php');
	$baseUrl .= $currentSelectedTheme."/";
}
require_once($baseUrl.'conf/config.php');
require_once('../../core/conf/config.php');
require_once('../../core/php/configStatic.php');

$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	$directory = "../../local/".$currentSelectedTheme."/Themes/".$currentTheme."/";
	require_once('../../local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	$directory = "../../core/Themes/".$currentTheme."/";
	require_once('../../core/Themes/'.$currentTheme."/defaultSetting.php");
}

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
		$newInfoForConfig .= putIntoCorrectFormat($key, $$key, $value);
	}
}
$newInfoForConfig .= "
	);
?>";


file_put_contents($fileName, $newInfoForConfig);

echo json_encode(true);
?>