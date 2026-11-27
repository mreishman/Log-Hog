<?php

$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."error.php"))
{
  $varToIndexDir .= "../";
  $countOfSlash++;
}
if(!isset($core))
{
	require_once($varToIndexDir.'core/php/class/core.php');
	$core = new core();
}
if(!isset($session))
{
	require_once($varToIndexDir.'core/php/class/session.php');
	$session = new session();
	$session->startSession();
}

$baseUrl = $varToIndexDir."local/";
$currentSelectedTheme = $session->returnCurrentSelectedThemeAjax();
$baseUrl .= $currentSelectedTheme."/";

$boolForUpgrade = true;
if(settingsData::exists($baseUrl.'conf/config.json'))
{
	$config = settingsData::read($baseUrl.'conf/config.json', 'config');
}
else
{
	$config = array();
	$boolForUpgrade = false;
}
if(settingsData::exists($varToIndexDir.'local/conf/globalConfig.json'))
{
	$globalConfig = settingsData::read($varToIndexDir.'local/conf/globalConfig.json', 'globalConfig');
}
else
{
	$globalConfig = array();
}
require_once($varToIndexDir."core/php/class/vars.php");
$vars = new vars();
$defaultConfig = settingsData::defaults('config');
$defaultGlobalConfig = settingsData::defaults('globalConfig');
$URI = $_SERVER['REQUEST_URI'];
$arrayOfUrlsToCheck = array("upgradeLayout","upgradeConfig","core/php/template/upgrade","upgradeTheme","themeChangeLogic","settingsSaveAjax","example","setup");
if($boolForUpgrade && !$vars->checkIfURIContains($arrayOfUrlsToCheck))
{
	$configVersion = 0;
	if(isset($config['configVersion']))
	{
		$configVersion = $config['configVersion'];
	}
	if((int)$configVersion < (int)$defaultConfig['configVersion'])
	{
		//redirect to upgrade script for config page
		header("Location: ".$varToIndexDir."core/php/template/upgradeConfig.php");
		exit();
	}

	$globalConfVersion = 0;
	if(isset($globalConfig['globalConfVersion']))
	{
		$globalConfVersion = $globalConfig['globalConfVersion'];
	}
	if((int)$globalConfVersion < (int)$defaultGlobalConfig['globalConfVersion'])
	{
		//redirect to upgrade script for config page
		header("Location: ".$varToIndexDir."core/php/template/upgradeGlobalConfig.php");
		exit();
	}

	$themeVersion = 0;
	if(isset($config['themeVersion']))
	{
		$themeVersion = $config['themeVersion'];
	}
	if((int)$themeVersion < (int)$defaultConfig['themeVersion'] || !is_file($baseUrl."/template/theme.css"))
	{
		//redirect to themeVersion upgrade script (copy over theme files to local)
		header("Location: ".$varToIndexDir."core/php/template/upgradeTheme.php");
		exit();

	}

	//check if upgrade script is needed
	$layoutVersion = 0;
	if(isset($globalConfig['layoutVersion']))
	{
		$layoutVersion = $globalConfig['layoutVersion'];
	}
	if((int)$layoutVersion < (int)$defaultGlobalConfig['layoutVersion'])
	{
		//redirect to upgrade script for layoutVersion page
		header("Location: ".$varToIndexDir."core/php/template/upgradeLayout.php");
		exit();
	}

}
//start loading vars
$loadCustomConfigVars = true;
if(isset($_POST['resetConfigValuesBackToDefault']))
{
	$loadCustomConfigVars = false;
}
$loadVarsArray = array();
foreach ($defaultConfig as $key => $value)
{
	$$key = $value;
	if(isset($_POST[$key]))
	{
		$$key = settingsData::input($_POST[$key], $value, $key);
	}
	elseif(array_key_exists($key, $config) && $vars->checkIfShouldLoad($loadCustomConfigVars, $key))
	{
		$$key = $config[$key];
	}
	elseif(isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings))
	{
		$$key = $themeDefaultSettings[$key];
	}
	elseif(array_key_exists($key, $config) && $vars->checkIfShouldLoad($loadCustomConfigVars, $key))
	{
		$$key = $globalConfig[$key];
	}
	$loadVarsArray[$key] = $$key;
}

foreach ($defaultGlobalConfig as $key => $value)
{
	$$key = $value;
	if(isset($_POST[$key]))
	{
		$$key = settingsData::input($_POST[$key], $value, $key);
	}
	elseif(array_key_exists($key, $globalConfig) && $vars->checkIfShouldLoad($loadCustomConfigVars, $key))
	{
		$$key = $globalConfig[$key];
	}

	$loadVarsArray[$key] = $$key;
}


foreach ($folderColorArrays as $key => $value)
{
	if($key == $currentFolderColorTheme)
	{
		$currentSelectedThemeColorValues = $value;
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	foreach (settingsData::structuredInput($_POST, $defaultConfig) as $key => $value)
	{
		$$key = $value;
	}
}
else
{
	// Image Vars

	$jsonImages = file_get_contents($varToIndexDir."core/json/images.json");
	$arrayOfImages = json_decode($jsonImages, true);


	foreach ($arrayOfImages as $key => $value)
	{
		$src = "core/img/".$value["baseName"];
		$filePaths = [
			"local/".$currentSelectedTheme."/img/".$value["baseName"],
			"local/Themes/".$currentTheme."/img/".$value["baseName"],
			"core/Themes/".$currentTheme."/img/".$value["baseName"],
			"local/Themes/".$currentThemeBase."/img/".$value["baseName"],
			"core/Themes/".$currentThemeBase."/img/".$value["baseName"]
		];
		foreach ($filePaths as $filePath)
		{
			if(file_exists($varToIndexDir.$filePath))
			{
				//check for local version
				$src = $filePath;
				break;
			}
		}

		$arrayOfImages[$key]["src"] = $varToIndexDir.$src;
		$arrayOfImages[$key]["version"] = $cssVersion;
	}

	if(!isset($session))
	{
		include($varToIndexDir."core/php/class/session.php");
		$session = new Session();
		$session->getInstance();
	}
	echo "<script>";
	echo "var successVerifyNum = ".$successVerifyNum.";";
	echo "var arrayOfImages = ".json_encode($arrayOfImages).";";
	echo "var formKey = \"".$session->outputKey()."\";";
	echo "</script>";

	$trueFalsVars = array(
		0 					=> array(
			"value" 			=> "true",
			"name" 				=> "True"),
		1 					=> array(
			"value" 			=> "false",
			"name" 				=> "False")
	);
}

$arrayOfCustomConfig = array(
	'themeVersion' => 1,
	'layoutVersion'	=> 1,
	'cssVersion'	=> 1,
	'configVersion'	=> 1
);


$modulesList = $core->getModules($moduleDisabledList);

$arrayOfDisabledModules = json_decode($moduleDisabledList, true);