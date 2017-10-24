<?php

require_once('verifyWriteStatus.php');
checkForUpdate($_SERVER['REQUEST_URI']);

//check for previous update, if failed

$varToIndexDir = "";
$countOfSlash = 0;
while($countOfSlash < 20 && !file_exists($varToIndexDir."error.php"))
{
  $varToIndexDir .= "../";        
}

$baseUrl = $varToIndexDir."core/";
if(file_exists($varToIndexDir.'local/layout.php'))
{
  $baseUrl = $varToIndexDir."local/";
  //there is custom information, use this
  require_once($varToIndexDir.'local/layout.php');
  $baseUrl .= $currentSelectedTheme."/";
}
$boolForUpgrade = true;
if(file_exists($baseUrl.'conf/config.php'))
{
	require_once($baseUrl.'conf/config.php'); 
}
else
{
	$config = array();
	$boolForUpgrade = false;
}
require_once($varToIndexDir.'core/conf/config.php');

$URI = $_SERVER['REQUEST_URI'];
$layoutVersion = 0;
$configVersion = 0;
if($boolForUpgrade && (strpos($URI, 'upgradeLayout') === false) && (strpos($URI, 'upgradeConfig') === false) && (strpos($URI, 'core/php/template/upgrade') === false))
{
	//check if upgrade script is needed
	
	if(isset($config['layoutVersion']))
	{
		$layoutVersion = $config['layoutVersion'];
	}
	if($layoutVersion !== $defaultConfig['layoutVersion'])
	{
		//redirect to upgrade script for layoutVersion page
		header("Location: ".$varToIndexDir."core/php/template/upgradeLayout.php");
		exit();
	}

	if(isset($config['configVersion']))
	{
		$configVersion = $config['configVersion'];
	}
	if($configVersion !== $defaultConfig['configVersion'])
	{
		//redirect to upgrade script for config page
		header("Location: ".$varToIndexDir."core/php/template/upgradeConfig.php");
		exit();
	}
}

foreach ($defaultConfig as $key => $value)
{
	if(isset($_POST[$key]))
	{
		$$key = $_POST[$key];
	}
	elseif(array_key_exists($key, $config))
	{
		$$key = $config[$key];
	}
	else
	{
		$$key = $value;
	} 
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

	$popupSettingsArraySave = "";
	if($popupSettings == "all")
	{
		$popupSettingsArraySave = "
			'saveSettings'	=>	'true',
			'versionCheck'	=> 'true'
			";
	}
	elseif($popupSettings == "none")
	{
		$popupSettingsArraySave = "
			'saveSettings'	=>	'false',
			'versionCheck'	=> 'false'
			";
	}
	else
	{
		if(isset($_POST['saveSettings']))
		{
			$popupSettingsArraySave = "
			'saveSettings'	=>	'".$_POST['saveSettings']."',
			'versionCheck'	=> '".$_POST['versionCheck']."'
			";
		}
		else
		{
			$popupSettingsArraySave = "";
			$count = 0;
			foreach ($popupSettingsCustom as $key => $value)
			{
				$popupSettingsArraySave .= "'".$key."'	=>	'".$value."'";
				$count++;
				if($count != 2)
				{
					$popupSettingsArraySave .= ",";
				}
			}
		}
	}
	$popupSettingsCustom = $popupSettingsArraySave;
}
?>