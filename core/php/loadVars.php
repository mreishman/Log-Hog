<?php

function forEachAddVars($variable)
{
	$returnText = "array(";
	foreach ($variable as $key => $value)
	{
		$returnText .= "'".$key."'	=>	";
		if(is_array($value) || is_object($value))
		{
			$returnText .= forEachAddVars($value);
		}
		else
		{
			$returnText .= "'".$value."',";
		}
	}
	$returnText .= "),";
	return $returnText;
}

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
if($boolForUpgrade && (strpos($URI, 'upgradeLayout') === false) && (strpos($URI, 'upgradeConfig') === false) && (strpos($URI, 'core/php/template/upgrade') === false) && (strpos($URI, 'upgradeTheme') === false) && (strpos($URI, 'themeChangeLogic') === false)) //
{
	$themeVersion = 0;
	if(isset($config['themeVersion']))
	{
		$themeVersion = $config['themeVersion'];
	}
	if($themeVersion != $defaultConfig['themeVersion'])
	{
		//redirect to themeVersion upgrade script (copy over theme files to local)
		header("Location: ".$varToIndexDir."settings/themes.php");
		exit();

	}

	//check if upgrade script is needed
	$layoutVersion = 0;
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

	$configVersion = 0;
	if(isset($config['configVersion']))
	{
		$configVersion = $config['configVersion'];
	}
	if($configVersion !== $defaultConfig['configVersion'] || !is_file($baseUrl."/template/theme.css"))
	{
		//redirect to upgrade script for config page
		header("Location: ".$varToIndexDir."core/php/template/upgradeConfig.php");
		exit();
	}
}
//start loading vars
$loadCustomConfigVars = true;
if(isset($_POST['resetConfigValuesBackToDefault']))
{
	$loadCustomConfigVars = false;
}
foreach ($defaultConfig as $key => $value)
{
	if(isset($_POST[$key]))
	{
		$$key = $_POST[$key];
	}
	elseif(array_key_exists($key, $config) && $loadCustomConfigVars)
	{
		$$key = $config[$key];
	}
	else
	{
		$$key = $value;
	}
}


foreach ($folderColorArrays as $key => $value)
{
	if($key == $currentFolderColorTheme)
	{
		$currentSelectedThemeColorValues = $value;
	}
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$arrayWatchList = "";
	if(isset($_POST['numberOfRows']))
	{
		for($i = 1; $i <= $_POST['numberOfRows']; $i++ )
		{
			$arrayWatchList .= "'".$_POST['watchListKey'.$i]."' => '".$_POST['watchListItem'.$i]."'";
			if($i != $_POST['numberOfRows'])
			{
				$arrayWatchList .= ",";
			}
		}
	}
	else
	{
		$numberOfRows = count($watchList);
		$i = 0;
		foreach ($watchList as $key => $value)
		{
			$i++;
			$arrayWatchList .= "'".$key."' => '".$value."'";
			if($i != $numberOfRows)
			{
				$arrayWatchList .= ",";
			}
		}
	}
	$watchList = $arrayWatchList;

	$popupSettingsArraySave = "";
	if($popupWarnings == "all")
	{
		$popupSettingsArraySave = "
			'saveSettings'	=>	'true',
			'blankFolder'	=>	'true',
			'deleteLog'	=>	'true',
			'removeFolder'	=> 	'true',
			'versionCheck'	=> 'true'
			";
	}
	elseif($popupWarnings == "none")
	{
		$popupSettingsArraySave = "
			'saveSettings'	=>	'false',
			'blankFolder'	=>	'false',
			'deleteLog'	=>	'false',
			'removeFolder'	=> 	'false',
			'versionCheck'	=> 'false'
			";
	}
	else
	{
		if(isset($_POST['saveSettings']))
		{
			$popupSettingsArraySave = "
			'saveSettings'	=>	'".$_POST['saveSettings']."',
			'blankFolder'	=>	'".$_POST['blankFolder']."',
			'deleteLog'	=>	'".$_POST['deleteLog']."',
			'removeFolder'	=> 	'".$_POST['removeFolder']."',
			'versionCheck'	=> '".$_POST['versionCheck']."'
			";
		}
		else
		{
			$popupSettingsArraySave = "";
			$count = 0;
			foreach ($popupSettingsArray as $key => $value)
			{
				$popupSettingsArraySave .= "'".$key."'	=>	'".$value."'";
				$count++;
				if($count != 4)
				{
					$popupSettingsArraySave .= ",";
				}
			}
		}
	}
	$popupSettingsArray = $popupSettingsArraySave;

	$folderColorArraysSave = "";
	if(isset($_POST['folderThemeCount']))
	{
		$intFolderThemeCount = intval($_POST['folderThemeCount']);
		for($i = 0; $i < $intFolderThemeCount; $i++ )
		{
			$folderColorArraysSave .= "'".$_POST['folderColorThemeNameForPost'.($i+1)]."'	=>	array(";
			$colorCount = 0;
			while (isset($_POST['folderColorValue'.($i+1).'-'.($colorCount+1)]))
			{
				$colorCount++;
				$folderColorArraysSave .= "'".$_POST['folderColorValue'.($i+1).'-'.($colorCount)]."',";
			}
			$folderColorArraysSave = substr($folderColorArraysSave, 0, -1);
			$folderColorArraysSave .= "),";
		}
	}
	else
	{
		foreach ($folderColorArrays as $key => $value)
		{
			$folderColorArraysSave .= "'".$key."'	=>	";
			$folderColorArraysSave .= forEachAddVars($value);
		}
	}
	$folderColorArrays = $folderColorArraysSave;
}
?>