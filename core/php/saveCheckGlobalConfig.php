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
$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."error.php"))
{
  $varToIndexDir .= "../";
}
require_once($varToIndexDir."core/php/class/core.php");
$core = new core();
require_once($varToIndexDir."core/php/class/vars.php");
$vars = new vars();

$baseUrl = $varToIndexDir."core/";
if(file_exists($varToIndexDir.'local/layout.php'))
{
  $baseUrl = $varToIndexDir."local/";
  //there is custom information, use this
  require_once($varToIndexDir.'local/layout.php');
  $baseUrl .= $currentSelectedTheme."/";
}
$globalConfig = array();
if(file_exists($varToIndexDir.'local/conf/globalConfig.php'))
{
	require_once($varToIndexDir.'local/conf/globalConfig.php');
}
require_once($varToIndexDir.'core/conf/globalConfig.php');
$config = array();
if(file_exists($baseUrl.'conf/config.php'))
{
	require_once($varToIndexDir.'core/conf/config.php');
}
require_once($baseUrl.'conf/config.php');
$currentTheme = $core->loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir($varToIndexDir.'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once($varToIndexDir.'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once($varToIndexDir.'core/Themes/'.$currentTheme."/defaultSetting.php");
}

$response = true;

foreach ($defaultConfig as $key => $value)
{
	if(isset($_POST[$key]))
	{
		if(array_key_exists($key, $globalConfig))
		{
			if($_POST[$key] != $config[$key])
			{
				$response = false;
				break;
			}
		}
		else
		{
			if($_POST[$key] != $value)
			{
				$response = false;
				break;
			}
		}

	}
}

echo json_encode($response);