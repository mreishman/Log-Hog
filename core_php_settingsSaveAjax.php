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
require_once("../../core/php/class/core.php");
$core = new core();
$baseUrl = "../../local/";
//there is custom information, use this
if(!file_exists($baseUrl."layout.php") || !is_readable($baseUrl."layout.php"))
{
	echo json_encode(7);
	exit();
}
require_once($baseUrl."layout.php");
if(!isset($currentSelectedTheme))
{
	echo json_encode(9);
	exit();
}
$baseUrl .= $currentSelectedTheme."/";

$config = array();
if(file_exists($baseUrl.'conf/config.php'))
{
	require_once($baseUrl.'conf/config.php');
	// Ok if it doesn't exist, user might have deleted to reset settings or something?
}

if (!file_exists("../../core/conf/config.php") || !is_readable("../../core/conf/config.php"))
{
	echo json_encode(8);
	exit();
}
require_once('../../core/conf/config.php');

if(!isset($defaultConfig))
{
	echo json_encode(10);
	exit();
}

$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
$requireFile = "../../core/Themes/".$currentTheme."/defaultSetting.php";
if(is_dir("../../local/".$currentSelectedTheme."/Themes/".$currentTheme))
{
	$requireFile = "../../local/".$currentSelectedTheme."/Themes/".$currentTheme."/defaultSetting.php";
}
require_once($requireFile);

require_once('loadVars.php');
if($backupNumConfigEnabled === "true")
{
	for ($i=$backupNumConfig; $i > 0; $i--)
	{
		$addonNum = "";
		if($i !== 1)
		{
			$addonNum = $i-1;
		}
		$fileNameOld = ''.$baseUrl.'conf/config'.$addonNum.'.php';
		$fileNameNew = ''.$baseUrl.'conf/config'.$i.'.php';
		if (file_exists($fileNameOld))
		{
			try
			{
				rename($fileNameOld, $fileNameNew);
			}
			catch (Exception $e)
			{
				echo json_encode(6);
				exit();
			}
		}
	}
}

$fileName = ''.$baseUrl.'conf/config.php';

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

if(is_writable($baseUrl."conf/"))
{
	if(file_exists($fileName))
	{
		unlink($fileName);
		if(!is_writable($fileName))
		{
			echo json_encode(4);
			exit();
		}
	}
	try
	{
		file_put_contents($fileName, $newInfoForConfig);
	}
	catch (Exception $e)
	{
		echo json_encode(5);
		exit();
	}

	echo json_encode(true);
	exit();
}
echo json_encode(3);
exit();