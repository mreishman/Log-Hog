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

function checkIfShouldLoad($loadCustomConfigVars, $key)
{
	if(!$loadCustomConfigVars)
	{
		$type = $_POST['resetConfigValuesBackToDefault'];
		if($type === "all")
		{
			return false;
		}

		if($type === "justWatch")
		{
			if($key === "watchList")
			{
				return false;
			}
			return true;
		}

		if($type === "allButWatch")
		{
			if($key !== "watchList")
			{
				return false;
			}
			return true;
		}
	}
	return true;
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
if($boolForUpgrade && (strpos($URI, 'upgradeLayout') === false) && (strpos($URI, 'upgradeConfig') === false) && (strpos($URI, 'core/php/template/upgrade') === false) && (strpos($URI, 'upgradeTheme') === false) && (strpos($URI, 'themeChangeLogic') === false) && (strpos($URI, 'settingsSaveAjax') === false) && (strpos($URI, 'example') === false))
{
	$themeVersion = 0;
	if(isset($config['themeVersion']))
	{
		$themeVersion = $config['themeVersion'];
	}
	if($themeVersion !== $defaultConfig['themeVersion'] || !is_file($baseUrl."/template/theme.css"))
	{
		//redirect to themeVersion upgrade script (copy over theme files to local)
		header("Location: ".$varToIndexDir."core/php/template/upgradeTheme.php");
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
	if($configVersion !== $defaultConfig['configVersion'])
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
	$$key = $value;
	if(isset($_POST[$key]))
	{
		$$key = $_POST[$key];
	}
	elseif(array_key_exists($key, $config) && checkIfShouldLoad($loadCustomConfigVars, $key))
	{
		$$key = $config[$key];
	}
	elseif(isset($themeDefaultSettings) && array_key_exists($key, $themeDefaultSettings))
	{
		$$key = $themeDefaultSettings[$key];
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
			$arrayWatchList .= "'".$_POST['watchListKey'.$i]."' => array(";
			$arrayWatchList .= "'AutoDeleteFiles' => '".$_POST['watchListKey'.$i.'AutoDeleteFiles']."',";
			$arrayWatchList .= "'ExcludeTrim' => '".$_POST['watchListKey'.$i.'ExcludeTrim']."',";
			$arrayWatchList .= "'FileInformation' => '".$_POST['watchListKey'.$i.'FileInformation']."',";
			$arrayWatchList .= "'FileType' => '".$_POST['watchListKey'.$i.'FileType']."',";
			$arrayWatchList .= "'Group' => '".$_POST['watchListKey'.$i.'Group']."',";
			$arrayWatchList .= "'Location' => '".$_POST['watchListKey'.$i.'Location']."',";
			$arrayWatchList .= "'Name' => '".$_POST['watchListKey'.$i.'Name']."',";
			$arrayWatchList .= "'Pattern' => '".$_POST['watchListKey'.$i.'Pattern']."',";
			$arrayWatchList .= "'Recursive' => '".$_POST['watchListKey'.$i.'Recursive']."'";
			$arrayWatchList .= ")";
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
	}
	$watchList = $arrayWatchList;

	$folderColorArraysSave = "";
	if(isset($_POST['folderThemeCount']))
	{
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
else
{
	// Image Vars

	$arrayOfImages = array(
		"backArrow"			=> array(
			"alt"			=>	"Back",
			"src"			=>	"",
			"title"			=>	"Back",
			"baseName"		=>	"backArrow.png"
		),
		"downArrowSideBar"	=> array(
			"alt"			=>	"Down",
			"src"			=>	"",
			"title"			=>	"Scroll To Bottom",
			"baseName"		=>	"downArrowSideBar.png"
		),
		"eraser"			=> array(
			"alt"			=>	"Clear",
			"src"			=>	"",
			"title"			=>	"Clear",
			"baseName"		=>	"eraser.png"
		),
		"eraserMulti"			=> array(
			"alt"			=>	"Clear All",
			"src"			=>	"",
			"title"			=>	"Clear All",
			"baseName"		=>	"eraserMulti.png"
		),
		"eraserSideBar"		=> array(
			"alt"			=>	"Clear",
			"src"			=>	"",
			"title"			=>	"Clear",
			"baseName"		=>	"eraserSideBar.png"
		),
		"externalLink"		=> array(
			"alt"			=>	"External Link",
			"src"			=>	"",
			"title"			=>	"External Link",
			"baseName"		=>	"externalLink.png"
		),
		"fileIcon"			=> array(
			"alt"			=>	"File",
			"src"			=>	"",
			"title"			=>	"File",
			"baseName"		=>	"fileIcon.png"
		),
		"fileIconNW"		=> array(
			"alt"			=>	"File Not Writeable",
			"src"			=>	"",
			"title"			=>	"File Not Writeable",
			"baseName"		=>	"fileIconNW.png"
		),
		"fileIconNR"		=> array(
			"alt"			=>	"File Not Readable",
			"src"			=>	"",
			"title"			=>	"File Not Readable",
			"baseName"		=>	"fileIconNR.png"
		),
		"folderIcon"		=> array(
			"alt"			=>	"Folder",
			"src"			=>	"",
			"title"			=>	"Folder",
			"baseName"		=>	"folderIcon.png"
		),
		"folderIconNR"		=> array(
			"alt"			=>	"Folder Not Readable",
			"src"			=>	"",
			"title"			=>	"Folder Not Readable",
			"baseName"		=>	"folderIconNR.png"
		),
		"folderIconNW"		=> array(
			"alt"			=>	"Folder Not Writeable",
			"src"			=>	"",
			"title"			=>	"Folder Not Writeable",
			"baseName"		=>	"folderIconNW.png"
		),
		"gear"		=> array(
			"alt"			=>	"Settings",
			"src"			=>	"",
			"title"			=>	"Settings",
			"baseName"		=>	"Gear.png"
		),
		"gitStatus"			=> array(
			"alt"			=> "gitStatus",
			'src'			=> "",
			"title"			=> "gitStatus",
			"baseName"		=> 'gitStatus.png'
		),	
		"greenCheck"		=> array(
			"alt"			=>	"Ok",
			"src"			=>	"",
			"title"			=>	"Ok!",
			"baseName"		=>	"greenCheck.png"
		),
		"info"			=> array(
			"alt"			=>	"Info",
			"src"			=>	"",
			"title"			=>	"Info",
			"baseName"		=>	"info.png"
		),
		"infoSideBar"		=> array(
			"alt"			=>	"Info",
			"src"			=>	"",
			"title"			=>	"Info",
			"baseName"		=>	"infoSideBar.png"
		),
		"loading"			=> array(
			"alt"			=>	"Loading",
			"src"			=>	"",
			"title"			=>	"Loading...",
			"baseName"		=>	"loading.gif"
		),
		"menu"	=> array(
			"alt"			=>	"Menu",
			"src"			=>	"",
			"title"			=>	"Menu",
			"baseName"		=>	"menu.png"
		),
		"notification"	=> array(
			"alt"			=>	"Notifications",
			"src"			=>	"",
			"title"			=>	"Notifications",
			"baseName"		=>	"notification.png"
		),
		"notificationClear"	=> array(
			"alt"			=>	"Clear Notifications",
			"src"			=>	"",
			"title"			=>	"Clear Notifications",
			"baseName"		=>	"notificationClear.png"
		),
		"notificationFull"	=> array(
			"alt"			=>	"Notifications",
			"src"			=>	"",
			"title"			=>	"Notifications",
			"baseName"		=>	"notificationFull.png"
		),
		"pause"			=> array(
			"alt"			=>	"Pause",
			"src"			=>	"",
			"title"			=>	"Pause",
			"baseName"		=>	"Pause.png"
		),
		"play"			=> array(
			"alt"			=>	"Play",
			"src"			=>	"",
			"title"			=>	"Play",
			"baseName"		=>	"Play.png"
		),
		"redWarning"		=> array(
			"alt"			=>	"Warning!",
			"src"			=>	"",
			"title"			=>	"Warning!!",
			"baseName"		=>	"redWarning.png"
		),
		"refresh"			=> array(
			"alt"			=>	"Refresh",
			"src"			=>	"",
			"title"			=>	"Refresh",
			"baseName"		=>	"Refresh.png"
		),
		"search"			=> array(
			"alt"			=>	"Search",
			"src"			=>	"",
			"title"			=>	"Search",
			"baseName"		=>	"search.png"
		),
		"seleniumMonitor"	=> array(
			"alt"			=>	"Selenium Monitor",
			"src"			=>	"",
			"title"			=>	"Selenium Monitor",
			"baseName"		=>	"seleniumMonitor.png"
		),
		"taskManager"		=> array(
			"alt"			=>	"TaskManager",
			"src"			=>	"",
			"title"			=>	"TaskManager",
			"baseName"		=>	"task-manager.png"
		),
		"trashCan"			=> array(
			"alt"			=>	"Delete",
			"src"			=>	"",
			"title"			=>	"Delete",
			"baseName"		=>	"trashCan.png"
		),
		"trashCanMulti"			=> array(
			"alt"			=>	"Delete Multiple",
			"src"			=>	"",
			"title"			=>	"Delete Multiple",
			"baseName"		=>	"trashCanMulti.png"
		),
		"trashCanSideBar"	=> array(
			"alt"			=>	"Delete",
			"src"			=>	"",
			"title"			=>	"Delete",
			"baseName"		=>	"trashCanSideBar.png"
		),
		"yellowWarning"		=> array(
			"alt"			=>	"Notice",
			"src"			=>	"",
			"title"			=>	"Notice!",
			"baseName"		=>	"yellowWarning.png"
		)
	);



	foreach ($arrayOfImages as $key => $value)
	{
		$src = "core/img/".$value["baseName"];

		if(file_exists($varToIndexDir."local/".$currentSelectedTheme."/img/".$value["baseName"]))
		{
			//check for local version
			$src = "local/".$currentSelectedTheme."/img/".$value["baseName"];
		}
		elseif(file_exists($varToIndexDir."local/Themes/".$currentTheme."/img/".$value["baseName"]))
		{
			//check for current theme in local
			$src = "local/Themes/".$currentTheme."/img/".$value["baseName"];
		}
		elseif(file_exists($varToIndexDir."core/Themes/".$currentTheme."/img/".$value["baseName"]))
		{
			//check for current theme in core
			$src = "core/Themes/".$currentTheme."/img/".$value["baseName"];
		}
		elseif(file_exists($varToIndexDir."core/Themes/".$currentThemeBase."/img/".$value["baseName"]))
		{
			//check for base theme
			$src = "core/Themes/".$currentThemeBase."/img/".$value["baseName"];
		}

		$arrayOfImages[$key]["src"] = $src;
	}

	echo "<script>";
	echo "var successVerifyNum = ".$successVerifyNum.";";
	echo "</script>";
}

$arrayOfCustomConfig = array(
	'themeVersion' => 1,
	'layoutVersion'	=> 1,
	'cssVersion'	=> 1,
	'configVersion'	=> 1
);