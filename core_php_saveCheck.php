<?php

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
if(file_exists($baseUrl.'conf/config.php'))
{
	require_once($baseUrl.'conf/config.php');
}
else
{
	$config = array();
}
require_once($varToIndexDir.'core/conf/config.php');

$response = true;


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
	$watchListSave = $arrayWatchList;
	$arrayWatchList = "";

	$numberOfRows = count($config['watchList']);
	$i = 0;
	foreach ($config['watchList'] as $key => $value)
	{
		$i++;
		$arrayWatchList .= "'".$key."' => '".$value."'";
		if($i != $numberOfRows)
		{
			$arrayWatchList .= ",";
		}
	}
	$watchList = $arrayWatchList;
}

if(isset($_POST['saveSettings']))
{
	if(array_key_exists('popupSettingsArray', $config))
	{
		$popupSettingsArray = $config['popupSettingsArray'];
	}
	else
	{
		$popupSettingsArray = $defaultConfig['popupSettingsArray'];
	}

	$popupSettingsArraySave = array(
	'saveSettings'	=>	$_POST['saveSettings'],
	'blankFolder'	=>	$_POST['blankFolder'],
	'deleteLog'	=>	$_POST['deleteLog'],
	'removeFolder'	=> 	$_POST['removeFolder'],
	'versionCheck'	=> $_POST['versionCheck']
	);
}

if(isset($_POST['folderThemeCount']))
{
	$folderColorArraysSave = "";
	$count = 0;
	foreach ($config['folderColorArrays'] as $key => $value)
	{
		$folderColorArraysSave .= "'".$key."'	=>	array(";
		$count++;
		foreach ($value as $key2 => $value2)
		{
			$folderColorArraysSave .= "'".$value2."',";
		}
		$folderColorArraysSave = substr($folderColorArraysSave, 0, -1);
		$folderColorArraysSave .= ")";
		$folderColorArraysSave .= ",";
	}
	$folderColorArrays = $folderColorArraysSave;
	$folderColorArraysSave = "";
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
		$folderColorArraysSave .= ")";
		$folderColorArraysSave .= ",";
	}
}

foreach ($defaultConfig as $key => $value)
{
	if(isset($_POST[$key]))
	{
		if(array_key_exists($key, $config))
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
	elseif(isset($$key))
	{
		$key2 = $key."Save";
		if($$key != $$key2)
		{
			$response = false;
			break;
		}
	}
}

echo json_encode($response);
?>