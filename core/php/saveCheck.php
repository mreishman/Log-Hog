<?php

function forEachAddVars($variable)
{
	$returnText = "array(";
	foreach ($variable as $key => $value)
	{
		$returnText .= " '".$key."' => ";
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
require_once($varToIndexDir."core/php/commonFunctions.php");

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

$currentTheme = loadSpecificVar($defaultConfig, $config, "currentTheme");
if(is_dir($varToIndexDir.'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme))
{
	require_once($varToIndexDir.'local/'.$currentSelectedTheme.'/Themes/'.$currentTheme."/defaultSetting.php");
}
else
{
	require_once($varToIndexDir.'core/Themes/'.$currentTheme."/defaultSetting.php");
}

$response = true;


$arrayWatchList = "";
if(isset($_POST['numberOfRows']))
{
	for($i = 1; $i <= $_POST['numberOfRows']; $i++ )
	{
		$arrayWatchList .= "'".$_POST['watchListKey'.$i]."' => array(";
		$arrayWatchList .= "'AutoDeleteFiles' => '".$_POST['watchListKey'.$i.'AutoDeleteFiles']."',";
		$arrayWatchList .= "'ExcludeTrim' => '".$_POST['watchListKey'.$i.'ExcludeTrim']."',";
		$arrayWatchList .= "'FileType' => '".$_POST['watchListKey'.$i.'FileType']."',";
		$arrayWatchList .= "'Group' => '".$_POST['watchListKey'.$i.'Group']."',";
		$arrayWatchList .= "'Location' => '".$_POST['watchListKey'.$i.'Location']."',";
		$arrayWatchList .= "'Pattern' => '".$_POST['watchListKey'.$i.'Pattern']."',";
		$arrayWatchList .= "'Recursive' => '".$_POST['watchListKey'.$i.'Recursive']."'";
		$arrayWatchList .= ")";
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
		if(is_array($value))
		{
			$arrayWatchList .= "'".$key."' => array(";
			$numberOfRows2 = count($value);
			$j = 0;
			foreach ($value as $key2 => $value2)
			{
				$j++;
				$arrayWatchList .= "'".$key2."' => '".$value2."'";
				if($j != $numberOfRows2)
				{
					$arrayWatchList .= ",";
				}
			}
			$arrayWatchList .= ")";
		}
		else
		{
			$arrayWatchList .= "'".$key."' => '".$value."'";
		}
		if($i != $numberOfRows)
		{
			$arrayWatchList .= ",";
		}
	}
	$watchList = $arrayWatchList;
}

if(isset($_POST['folderThemeCount']))
{
	$folderColorArraysSave = "";
	foreach ($config['folderColorArrays'] as $key => $value)
	{
		$folderColorArraysSave .= "'".$key."'	=>	";
		$folderColorArraysSave .= forEachAddVars($value);
	}
	$folderColorArrays = $folderColorArraysSave;
	$folderColorArraysSave = "";
	$intFolderThemeCount = intval($_POST['folderThemeCount']);
		for($i = 0; $i < $intFolderThemeCount; $i++ )
		{
			$folderColorArraysSave .= "'".$_POST['folderColorThemeNameForPost'.($i+1)]."'	=>	array(";

				//main
				$folderColorArraysSave .= " 'main' => array(";

					$colorCount = 0;
					while (isset($_POST['folderColorValueMainBackground'.($i+1).'-'.($colorCount+1)]))
					{
						$colorCount++;
						$folderColorArraysSave .= " 'main-".($colorCount)."' => array(";
						$folderColorArraysSave .= " 'background' => '".$_POST['folderColorValueMainBackground'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= " 'fontColor' => '".$_POST['folderColorValueMainFont'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= "),";
					}

				$folderColorArraysSave .= "),";

				//highlight
				$folderColorArraysSave .= " 'highlight' => array(";

					$colorCount = 0;
					while (isset($_POST['folderColorValueHighlightBackground'.($i+1).'-'.($colorCount+1)]))
					{
						$colorCount++;
						$folderColorArraysSave .= " 'highlight-".($colorCount)."' => array(";
						$folderColorArraysSave .= " 'background' => '".$_POST['folderColorValueHighlightBackground'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= " 'fontColor' => '".$_POST['folderColorValueHighlightFont'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= "),";
					}

				$folderColorArraysSave .= "),";

				//active
				$folderColorArraysSave .= " 'active' => array(";

					$colorCount = 0;
					while (isset($_POST['folderColorValueActiveBackground'.($i+1).'-'.($colorCount+1)]))
					{
						$colorCount++;
						$folderColorArraysSave .= " 'active-".($colorCount)."' => array(";
						$folderColorArraysSave .= " 'background' => '".$_POST['folderColorValueActiveBackground'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= " 'fontColor' => '".$_POST['folderColorValueActiveFont'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= "),";
					}

				$folderColorArraysSave .= "),";

				//highlightActive
				$folderColorArraysSave .= " 'highlightActive' => array(";

					$colorCount = 0;
					while (isset($_POST['folderColorValueActiveHighlightBackground'.($i+1).'-'.($colorCount+1)]))
					{
						$colorCount++;
						$folderColorArraysSave .= " 'highlightActive-".($colorCount)."' => array(";
						$folderColorArraysSave .= " 'background' => '".$_POST['folderColorValueActiveHighlightBackground'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= " 'fontColor' => '".$_POST['folderColorValueActiveHighlightFont'.($i+1).'-'.($colorCount)]."',";
						$folderColorArraysSave .= "),";
					}

				$folderColorArraysSave .= "),";

			$folderColorArraysSave .= "),";
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
		elseif(array_key_exists($key, $themeDefaultSettings))
		{
			if($_POST[$key] != $themeDefaultSettings[$key])
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
	elseif(isset($$key) && $key !== "currentTheme")
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